<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\ConsultationCallRecording;
use App\Models\ConsultationCallRequest;
use App\Models\ConsultationCallSession;
use App\Models\ConsultationRequest;
use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CallRequestController extends Controller
{
    public function update(Request $request, ConsultationCallRequest $callRequest): RedirectResponse
    {
        abort_unless($callRequest->professional_id === $request->user()->id, 403);

        $data = $request->validate([
            'status_action' => ['required', 'in:approve,decline'],
            'scheduled_at' => ['nullable', 'required_if:status_action,approve', 'date', 'after:now'],
        ]);

        $consultation = $callRequest->consultation;

        if ($data['status_action'] === 'decline') {
            $callRequest->update([
                'status' => 'declined',
                'reviewed_at' => now(),
                'reviewed_by' => $request->user()->id,
            ]);

            Notification::create([
                'recipient_id' => $callRequest->student_id,
                'type' => 'consultation_call_declined',
                'message' => 'Your call request was reviewed. The professional did not schedule a call at this time.',
                'linked_entity_type' => ConsultationRequest::class,
                'linked_entity_id' => (string) $consultation->getKey(),
            ]);

            return back()->with('status', 'Call request declined.');
        }

        $callSession = ConsultationCallSession::create([
            'consultation_request_id' => $consultation->id,
            'student_id' => $callRequest->student_id,
            'professional_id' => $request->user()->id,
            'provider' => config('services.video.provider', 'pending'),
            'room_name' => 'consultation-'.$consultation->tracking_code.'-'.Str::lower(Str::random(8)),
            'scheduled_at' => $data['scheduled_at'],
            'status' => 'scheduled',
            'recording_enabled' => true,
        ]);

        ConsultationCallRecording::create([
            'consultation_request_id' => $consultation->id,
            'consultation_call_session_id' => $callSession->id,
            'provider' => $callSession->provider,
            'status' => 'scheduled',
            'delete_after' => now()->addDays(90),
        ]);

        $callRequest->update([
            'status' => 'approved',
            'reviewed_at' => now(),
            'reviewed_by' => $request->user()->id,
        ]);

        Notification::create([
            'recipient_id' => $callRequest->student_id,
            'type' => 'consultation_call_scheduled',
            'message' => 'Your call request was approved and a recorded call has been scheduled.',
            'linked_entity_type' => ConsultationRequest::class,
            'linked_entity_id' => (string) $consultation->getKey(),
        ]);

        return back()->with('status', 'Call request approved and scheduled.');
    }
}
