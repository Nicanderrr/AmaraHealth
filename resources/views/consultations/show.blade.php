@extends('layouts.app')

@section('content')
@include('partials.page-header', [
    'eyebrow' => 'Consultation details',
    'title' => $consultation->subject,
    'description' => $consultation->symptoms,
    'actions' => [
        ['label' => 'Back to requests', 'href' => route('consultations.index')],
    ],
])

<section class="container pb-5">
    <div class="panel-card p-4 p-lg-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <span class="theme-pill">{{ $consultation->tracking_code }}</span>
            <span class="text-uppercase small text-muted">{{ $consultation->status }}</span>
        </div>
        <div class="stack-grid cols-2 mb-4">
            <div class="border rounded-4 p-3">
                <strong>Concern type</strong>
                <div class="text-muted">{{ $consultation->concern_type }}</div>
            </div>
            <div class="border rounded-4 p-3">
                <strong>Urgency</strong>
                <div class="text-muted">{{ $consultation->urgency }}</div>
            </div>
            <div class="border rounded-4 p-3">
                <strong>Assigned professional</strong>
                <div class="text-muted">
                    @if ($consultation->assignedProfessional)
                        {{ $consultation->assignedProfessional->display_name ?: $consultation->assignedProfessional->name }}
                        @if ($consultation->assignedProfessional->professional_title)
                            ({{ $consultation->assignedProfessional->professional_title }})
                        @endif
                    @else
                        Awaiting assignment
                    @endif
                </div>
            </div>
            <div class="border rounded-4 p-3">
                <strong>Assigned at</strong>
                <div class="text-muted">{{ $consultation->assigned_at ? $consultation->assigned_at->format('M d, Y g:i A') : 'Not assigned yet' }}</div>
            </div>
        </div>
        @if ($consultation->questions)
            <div class="border rounded-4 p-3 mb-4">
                <strong>Questions</strong>
                <div class="mt-2">{{ $consultation->questions }}</div>
            </div>
        @endif
        <div class="border rounded-4 p-4 mb-4">
            <h3 class="mb-3">Request a call</h3>
            @if ($consultation->status === 'closed')
                <p class="mb-0 text-muted">This consultation is closed, so new call requests are disabled.</p>
            @elseif ($consultation->callRequests()->where('student_id', auth()->id())->where('status', 'pending')->exists())
                <p class="mb-0 text-muted">You already have a pending call request for this consultation.</p>
            @else
                <form method="post" action="{{ route('consultations.call-requests.store', $consultation) }}" class="row g-3">
                    @csrf
                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold">Call type</label>
                        <select name="call_type" class="form-select theme-input" required>
                            <option value="video">Video call</option>
                            <option value="audio">Audio call</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold">Preferred time</label>
                        <input type="datetime-local" name="preferred_at" class="form-control theme-input">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Reason</label>
                        <textarea name="reason" rows="3" class="form-control theme-input" maxlength="500" placeholder="Briefly explain why you want a live call."></textarea>
                    </div>
                    <div class="col-12">
                        <button class="thm-btn thm-btn--sm" type="submit">
                            <span class="thm-btn-text">Send call request</span>
                        </button>
                    </div>
                </form>
            @endif

            @if ($consultation->callRequests()->where('student_id', auth()->id())->exists())
                <div class="mt-4">
                    <strong>Previous requests</strong>
                    @foreach ($consultation->callRequests()->where('student_id', auth()->id())->latest()->get() as $callRequest)
                        <div class="d-flex flex-wrap justify-content-between gap-3 py-2 border-bottom">
                            <span>{{ ucfirst($callRequest->call_type) }} call</span>
                            <span class="theme-pill">{{ $callRequest->status }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="border rounded-4 p-4 mb-4">
            <h3 class="mb-3">Recorded calls</h3>
            @forelse ($consultation->callSessions()->latest()->get() as $callSession)
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 py-3 border-bottom">
                    <div>
                        <strong>{{ $callSession->scheduled_at ? $callSession->scheduled_at->format('M d, Y g:i A') : 'Call session' }}</strong>
                        <div class="text-muted small">Status: {{ str_replace('_', ' ', $callSession->status) }}</div>
                    </div>
                    <a class="thm-btn thm-btn--sm" href="{{ route('call-sessions.show', $callSession) }}">
                        <span class="thm-btn-text">Join call</span>
                    </a>
                </div>
            @empty
                <p class="mb-0 text-muted">No call sessions have been scheduled yet.</p>
            @endforelse
        </div>
        <div class="border rounded-4 p-4">
            <h3 class="mb-3">Clinician response</h3>
            @if ($consultation->response)
                <div class="lh-lg">{!! nl2br(e($consultation->response)) !!}</div>
            @else
                <p class="mb-0 text-muted">No response yet. Check back later.</p>
            @endif
        </div>
    </div>
</section>
@endsection
