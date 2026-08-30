<?php

namespace App\Http\Controllers;

use App\Models\ConsultationCallRequest;
use App\Models\ConsultationRequest;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ConsultationCallRequestController extends Controller
{
    public function store(Request $request, ConsultationRequest $consultation): RedirectResponse
    {
        abort_unless($consultation->user_id === $request->user()->id, 403);
        abort_if($consultation->status === 'closed', 422, 'Closed consultations cannot receive call requests.');

        $data = $request->validate([
            'call_type' => ['required', 'in:audio,video'],
            'reason' => ['nullable', 'string', 'max:500'],
            'preferred_at' => ['nullable', 'date', 'after:now'],
        ]);

        $openRequestExists = $consultation->callRequests()
            ->where('student_id', $request->user()->id)
            ->where('status', 'pending')
            ->exists();

        if ($openRequestExists) {
            return back()->withErrors(['call_request' => 'You already have a pending call request for this consultation.']);
        }

        $callRequest = ConsultationCallRequest::create([
            'consultation_request_id' => $consultation->id,
            'student_id' => $request->user()->id,
            'professional_id' => $consultation->assigned_professional_id,
            'call_type' => $data['call_type'],
            'reason' => $data['reason'] ?? null,
            'preferred_at' => $data['preferred_at'] ?? null,
            'status' => 'pending',
        ]);

        if ($consultation->assigned_professional_id) {
            Notification::create([
                'recipient_id' => $consultation->assigned_professional_id,
                'type' => 'consultation_call_requested',
                'message' => 'A student requested a '.($data['call_type'] === 'audio' ? 'phone' : 'video').' call.',
                'linked_entity_type' => ConsultationRequest::class,
                'linked_entity_id' => (string) $consultation->getKey(),
            ]);
        } else {
            User::query()
                ->where('role', 'admin')
                ->get()
                ->each(function (User $admin) use ($consultation) {
                    Notification::create([
                        'recipient_id' => $admin->id,
                        'type' => 'consultation_call_requested_unassigned',
                        'message' => 'A student requested a call on an unassigned consultation.',
                        'linked_entity_type' => ConsultationRequest::class,
                        'linked_entity_id' => (string) $consultation->getKey(),
                    ]);
                });
        }

        return back()->with('status', 'Call request sent.');
    }
}
