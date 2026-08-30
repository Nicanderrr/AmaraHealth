<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\ConsultationRequest;
use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConsultationController extends Controller
{
    public function index(Request $request): View
    {
        return view('professional.consultations.index', [
            'consultations' => ConsultationRequest::query()
                ->where('assigned_professional_id', $request->user()->id)
                ->latest('assigned_at')
                ->paginate(10),
        ]);
    }

    public function show(ConsultationRequest $consultation, Request $request): View
    {
        abort_unless($consultation->assigned_professional_id === $request->user()->id || $request->user()->role === 'admin', 403);

        return view('professional.consultations.show', [
            'consultation' => $consultation,
        ]);
    }

    public function update(Request $request, ConsultationRequest $consultation): RedirectResponse
    {
        abort_unless($consultation->assigned_professional_id === $request->user()->id, 403);

        $data = $request->validate([
            'assessment_summary' => ['nullable', 'string', 'max:500'],
            'general_advice' => ['nullable', 'string', 'max:800'],
            'pre_visit_preparation' => ['nullable', 'string', 'max:400'],
            'visit_recommended' => ['required', 'in:yes,no,urgent'],
            'priority_level' => ['required', 'in:routine,soon,urgent'],
            'urgent_reason' => ['nullable', 'string', 'max:400'],
            'follow_up_instructions' => ['nullable', 'string', 'max:400'],
            'status_action' => ['required', 'in:save,request_info,close'],
            'follow_up_message' => ['nullable', 'string', 'max:500'],
        ]);

        if ($data['priority_level'] === 'urgent' && empty($data['urgent_reason'])) {
            return back()->withErrors(['urgent_reason' => 'An urgent recommendation requires a reason.'])->withInput();
        }

        $recommendation = [
            'assessment_summary' => $data['assessment_summary'] ?? '',
            'general_advice' => $data['general_advice'] ?? '',
            'pre_visit_preparation' => $data['pre_visit_preparation'] ?? '',
            'visit_recommended' => $data['visit_recommended'],
            'priority_level' => $data['priority_level'],
            'urgent_reason' => $data['priority_level'] === 'urgent' ? ($data['urgent_reason'] ?? '') : null,
            'follow_up_instructions' => $data['follow_up_instructions'] ?? '',
        ];

        $status = match ($data['status_action']) {
            'request_info' => 'awaiting_student_response',
            'close' => 'closed',
            default => 'response_ready',
        };

        $consultation->update([
            'recommendation' => $recommendation,
            'response' => trim(implode("\n\n", array_filter([
                $data['assessment_summary'] ?? null,
                $data['general_advice'] ?? null,
                $data['pre_visit_preparation'] ?? null,
                $data['follow_up_instructions'] ?? null,
            ]))),
            'status' => $status,
            'responded_at' => in_array($status, ['response_ready', 'closed'], true) ? now() : $consultation->responded_at,
            'closed_at' => $status === 'closed' ? now() : $consultation->closed_at,
            'status_history' => array_merge($consultation->status_history ?? [], [
                ['status' => $status, 'changed_at' => now()->toISOString(), 'changed_by' => $request->user()->id],
            ]),
        ]);

        Notification::create([
            'recipient_id' => $consultation->user_id,
            'type' => $status === 'awaiting_student_response' ? 'consultation_follow_up' : 'consultation_response',
            'message' => $status === 'awaiting_student_response'
                ? 'Your health professional has a follow-up question about your consultation.'
                : 'Your health professional has responded to your consultation.',
            'linked_entity_type' => ConsultationRequest::class,
            'linked_entity_id' => (string) $consultation->getKey(),
        ]);

        return redirect()
            ->route('professional.consultations.show', $consultation)
            ->with('status', 'Consultation updated.');
    }
}
