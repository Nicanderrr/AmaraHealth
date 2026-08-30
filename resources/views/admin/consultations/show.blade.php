@extends('layouts.admin')

@php
    $pageTitle = $consultation->subject;
    $subtitle = 'Review the intake and submit a structured recommendation.';

    $statusClass = [
        'submitted' => 'text-bg-secondary',
        'assigned' => 'text-bg-primary',
        'under_review' => 'text-bg-info',
        'awaiting_student_response' => 'text-bg-warning',
        'response_ready' => 'text-bg-success',
        'closed' => 'text-bg-dark',
        'unassigned' => 'text-bg-light border text-dark',
    ];
@endphp

@section('page-actions')
    <a href="{{ route('admin.consultations.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>
        Back to requests
    </a>
@endsection

@section('content')
    <section class="row g-3">
        <div class="col-12 col-xl-5">
            <div class="panel h-100">
                <div class="panel-header">
                    <h2 class="h5 mb-1 section-title"><i class="bi bi-clipboard2-pulse" aria-hidden="true"></i><span>Consultation details</span></h2>
                    <p class="text-muted mb-0">Review the intake information before recording the response.</p>
                </div>

                <div class="list-group list-group-flush">
                    <div class="list-group-item px-0 d-flex justify-content-between gap-3">
                        <span class="text-muted">Tracking code</span>
                        <span class="fw-semibold">{{ $consultation->tracking_code }}</span>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between gap-3">
                        <span class="text-muted">Concern type</span>
                        <span class="fw-semibold text-end">{{ $consultation->concern_type }}</span>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between gap-3">
                        <span class="text-muted">Urgency</span>
                        <span class="fw-semibold">{{ $consultation->urgency }}</span>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between gap-3">
                        <span class="text-muted">Assigned professional</span>
                        <span class="fw-semibold text-end">
                            @if ($consultation->assignedProfessional)
                                {{ $consultation->assignedProfessional->display_name ?: $consultation->assignedProfessional->name }}
                                @if ($consultation->assignedProfessional->professional_title)
                                    <span class="d-block text-muted fw-normal small">{{ $consultation->assignedProfessional->professional_title }}</span>
                                @endif
                            @else
                                Awaiting assignment
                            @endif
                        </span>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between gap-3">
                        <span class="text-muted">Assigned at</span>
                        <span class="fw-semibold text-end">{{ $consultation->assigned_at ? $consultation->assigned_at->format('M d, Y g:i A') : 'Not assigned yet' }}</span>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between gap-3">
                        <span class="text-muted">Status</span>
                        <span class="badge {{ $statusClass[$consultation->status] ?? 'text-bg-secondary' }}">{{ str_replace('_', ' ', $consultation->status) }}</span>
                    </div>
                    <div class="list-group-item px-0">
                        <div class="text-muted mb-1">Symptoms</div>
                        <p class="mb-0">{{ $consultation->symptoms }}</p>
                    </div>
                    <div class="list-group-item px-0">
                        <div class="text-muted mb-1">Questions / notes</div>
                        <p class="mb-0">{{ $consultation->questions ?: 'No extra notes provided.' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-7">
            <div class="panel mb-3">
                <div class="panel-header">
                    <h2 class="h5 mb-1 section-title"><i class="bi bi-record-circle" aria-hidden="true"></i><span>Call recordings</span></h2>
                    <p class="text-muted mb-0">Admin-only access. Every playback request is written to the audit log.</p>
                </div>

                <div class="list-group list-group-flush">
                    @forelse ($consultation->callRecordings()->with('session')->latest()->get() as $recording)
                        <div class="list-group-item px-0 d-flex flex-wrap justify-content-between align-items-center gap-3">
                            <div>
                                <span class="fw-semibold">
                                    {{ $recording->started_at ? $recording->started_at->format('M d, Y g:i A') : ($recording->session?->scheduled_at?->format('M d, Y g:i A') ?? 'Recording pending') }}
                                </span>
                                <span class="badge text-bg-secondary ms-2">{{ str_replace('_', ' ', $recording->status) }}</span>
                                <div class="text-muted small">
                                    Retention: {{ $recording->delete_after ? 'delete after '.$recording->delete_after->format('M d, Y') : 'not set' }}
                                </div>
                            </div>
                            @if ($recording->storage_path && ! $recording->deleted_at)
                                <a href="{{ route('admin.recordings.show', $recording) }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-play-circle me-1" aria-hidden="true"></i>
                                    Open recording
                                </a>
                            @else
                                <span class="text-muted small">Recording file not available yet.</span>
                            @endif
                        </div>
                    @empty
                        <p class="text-muted mb-0">No recorded calls have been created for this consultation.</p>
                    @endforelse
                </div>
            </div>

            <div class="panel h-100">
                <div class="panel-header">
                    <h2 class="h5 mb-1 section-title"><i class="bi bi-send-check" aria-hidden="true"></i><span>Response workflow</span></h2>
                    <p class="text-muted mb-0">Update the status and add your response in one pass.</p>
                </div>

                <form method="post" action="{{ route('admin.consultations.update', $consultation) }}" class="row g-3">
                    @csrf
                    @method('PUT')
                    <div class="col-12">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="submitted" @selected($consultation->status === 'submitted')>Submitted</option>
                            <option value="assigned" @selected($consultation->status === 'assigned')>Assigned</option>
                            <option value="under_review" @selected($consultation->status === 'under_review')>Under review</option>
                            <option value="awaiting_student_response" @selected($consultation->status === 'awaiting_student_response')>Awaiting student response</option>
                            <option value="response_ready" @selected($consultation->status === 'response_ready')>Response ready</option>
                            <option value="closed" @selected($consultation->status === 'closed')>Closed</option>
                            <option value="unassigned" @selected($consultation->status === 'unassigned')>Unassigned</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Response</label>
                        <textarea name="response" rows="12" class="form-control" required>{{ old('response', $consultation->response) }}</textarea>
                    </div>
                    <div class="col-12 d-flex flex-wrap gap-2">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-send me-1" aria-hidden="true"></i>
                            Save response
                        </button>
                        <a href="{{ route('admin.consultations.index') }}" class="btn btn-outline-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
