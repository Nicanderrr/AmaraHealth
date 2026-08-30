@extends('layouts.app')

@section('content')
@php
    $backRoute = match (auth()->user()->role) {
        'admin' => route('admin.consultations.show', $callSession->consultation),
        'professional' => route('professional.consultations.show', $callSession->consultation),
        default => route('consultations.show', $callSession->consultation),
    };
@endphp

@include('partials.page-header', [
    'eyebrow' => 'Private call room',
    'title' => $callSession->consultation->subject,
    'description' => 'This call belongs to consultation '.$callSession->consultation->tracking_code.' and includes a clear recording notice before anyone joins.',
    'actions' => [
        ['label' => 'Back to consultation', 'href' => $backRoute],
    ],
])

<section class="container pb-5">
    @unless ($consented)
        <div class="panel-card p-4 p-lg-5">
            <div class="alert alert-warning mb-4" role="alert">
                This call will be recorded for safety and quality review. Recordings are private and can only be accessed by authorized admins.
            </div>
            <form method="post" action="{{ route('call-sessions.consent', $callSession) }}" class="stack-grid">
                @csrf
                <label class="border rounded-4 p-3 d-flex align-items-start gap-3">
                    <input type="checkbox" name="recording_consent" value="1" class="form-check-input mt-1" required>
                    <span>
                        <span class="d-block fw-semibold">I understand and consent to this recorded consultation call.</span>
                        <span class="text-muted small">Do not join if you do not consent to recording.</span>
                    </span>
                </label>
                <div>
                    <button class="thm-btn" type="submit">
                        <span class="thm-btn-text">Join recorded call</span>
                    </button>
                </div>
            </form>
        </div>
    @else
        <div class="panel-card p-4 p-lg-5">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                <div>
                    <span class="theme-pill">Room: {{ $callSession->room_name }}</span>
                    <p class="text-muted mb-0 mt-2">The video provider will load here after the media SDK is connected.</p>
                </div>
                <span class="badge text-bg-danger px-3 py-2">Recording</span>
            </div>

            <div class="ratio ratio-16x9 border rounded-4 bg-dark d-flex align-items-center justify-content-center text-white mb-4">
                <div class="text-center p-4">
                    <h2 class="h4 mb-2 text-white">Recorded call room ready</h2>
                    <p class="mb-0">Camera, microphone, and participant video tiles will render in this area.</p>
                </div>
            </div>

            <div class="alert alert-warning mb-0" role="alert">
                Recording is active while this consultation room is live.
            </div>
        </div>
    @endunless
</section>
@endsection
