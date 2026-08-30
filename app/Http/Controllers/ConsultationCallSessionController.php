<?php

namespace App\Http\Controllers;

use App\Models\ConsultationCallSession;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConsultationCallSessionController extends Controller
{
    public function show(ConsultationCallSession $callSession, Request $request): View
    {
        $this->authorizeParticipant($callSession, $request);

        $consented = $this->hasConsented($callSession, $request);

        return view('consultations.call-room', [
            'callSession' => $callSession->load(['consultation', 'recording']),
            'consented' => $consented,
        ]);
    }

    public function consent(ConsultationCallSession $callSession, Request $request): RedirectResponse
    {
        $this->authorizeParticipant($callSession, $request);

        $request->validate([
            'recording_consent' => ['accepted'],
        ]);

        $column = $request->user()->id === $callSession->student_id
            ? 'student_consented_at'
            : 'professional_consented_at';

        $updates = [$column => now()];

        if (! $callSession->started_at) {
            $updates['started_at'] = now();
            $updates['status'] = 'live';
        }

        $callSession->update($updates);

        $callSession->recording?->update([
            'status' => 'recording',
            'started_at' => $callSession->recording->started_at ?? now(),
        ]);

        return redirect()->route('call-sessions.show', $callSession);
    }

    private function authorizeParticipant(ConsultationCallSession $callSession, Request $request): void
    {
        $user = $request->user();

        abort_unless(
            $user
            && (
                $user->id === $callSession->student_id
                || $user->id === $callSession->professional_id
                || $user->role === 'admin'
            ),
            403
        );
    }

    private function hasConsented(ConsultationCallSession $callSession, Request $request): bool
    {
        if ($request->user()->id === $callSession->student_id) {
            return (bool) $callSession->student_consented_at;
        }

        if ($request->user()->id === $callSession->professional_id) {
            return (bool) $callSession->professional_consented_at;
        }

        return true;
    }
}
