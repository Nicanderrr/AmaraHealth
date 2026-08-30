<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\ConsultationRequest;
use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConsultationController extends Controller
{
    public function index(): View
    {
        return view('admin.consultations.index', [
            'requests' => ConsultationRequest::query()->with('assignedProfessional')->latest()->paginate(10),
        ]);
    }

    public function show(ConsultationRequest $consultation): View
    {
        return view('admin.consultations.show', [
            'consultation' => $consultation->load('assignedProfessional'),
        ]);
    }

    public function update(Request $request, ConsultationRequest $consultation): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:submitted,assigned,under_review,awaiting_student_response,response_ready,closed,unassigned'],
            'response' => ['required', 'string', 'max:5000'],
        ]);

        $consultation->update([
            'status' => $data['status'],
            'response' => $data['response'],
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ]);

        AuditLog::create([
            'admin_id' => $request->user()->id,
            'action' => 'update_consultation_metadata',
            'target_entity_type' => ConsultationRequest::class,
            'target_entity_id' => (string) $consultation->getKey(),
            'reason' => 'Updated consultation metadata from admin panel.',
        ]);

        Notification::create([
            'recipient_id' => $consultation->user_id,
            'type' => 'consultation_admin_updated',
            'message' => 'Your consultation was updated by the admin team.',
            'linked_entity_type' => ConsultationRequest::class,
            'linked_entity_id' => (string) $consultation->getKey(),
        ]);

        return redirect()->route('admin.consultations.index')->with('status', 'Consultation updated.');
    }
}
