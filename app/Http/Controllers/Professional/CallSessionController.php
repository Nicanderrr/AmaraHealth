<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\ConsultationCallRecording;
use App\Models\ConsultationCallSession;
use App\Models\ConsultationRequest;
use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CallSessionController extends Controller
{
    public function store(Request $request, ConsultationRequest $consultation): RedirectResponse
    {
        abort_unless($consultation->assigned_professional_id === $request->user()->id, 403);

        $data = $request->validate([
            'scheduled_at' => ['nullable', 'date'],
        ]);

        $callSession = ConsultationCallSession::create([
            'consultation_request_id' => $consultation->id,
            'student_id' => $consultation->user_id,
            'professional_id' => $request->user()->id,
            'provider' => config('services.video.provider', 'pending'),
            'room_name' => 'consultation-'.$consultation->tracking_code.'-'.Str::lower(Str::random(8)),
            'scheduled_at' => $data['scheduled_at'] ?? null,
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

        Notification::create([
            'recipient_id' => $consultation->user_id,
            'type' => 'consultation_call_scheduled',
            'message' => 'A recorded video consultation has been scheduled. Review the recording notice before joining.',
            'linked_entity_type' => ConsultationRequest::class,
            'linked_entity_id' => (string) $consultation->getKey(),
        ]);

        return redirect()
            ->route('professional.consultations.show', $consultation)
            ->with('status', 'Recorded call session created.');
    }
}
