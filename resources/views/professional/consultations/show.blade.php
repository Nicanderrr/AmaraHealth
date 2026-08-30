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
    <a href="{{ route('professional.consultations.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>
        Back to queue
    </a>
@endsection

@section('content')
    <section class="row g-3">
        <div class="col-12 col-xl-5">
            <div class="panel h-100">
                <div class="panel-header">
                    <h2 class="h5 mb-1 section-title"><i class="bi bi-clipboard2-pulse" aria-hidden="true"></i><span>Consultation intake</span></h2>
                    <p class="text-muted mb-0">The intake summary is visible in read-only format.</p>
                </div>

                <div class="list-group list-group-flush">
                    <div class="list-group-item px-0 d-flex justify-content-between gap-3">
                        <span class="text-muted">Tracking code</span>
                        <span class="fw-semibold">{{ $consultation->tracking_code }}</span>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between gap-3">
                        <span class="text-muted">Category</span>
                        <span class="fw-semibold text-end">{{ $consultation->concern_category }}</span>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between gap-3">
                        <span class="text-muted">Status</span>
                        <span class="badge {{ $statusClass[$consultation->status] ?? 'text-bg-secondary' }}">{{ str_replace('_', ' ', $consultation->status) }}</span>
                    </div>
                    <div class="list-group-item px-0">
                        <div class="text-muted mb-1">Symptoms</div>
                        <p class="mb-0">{{ $consultation->symptoms ?? 'No symptoms provided.' }}</p>
                    </div>
                    <div class="list-group-item px-0">
                        <div class="text-muted mb-1">Submitted answers</div>
                        <dl class="mb-0">
                            @foreach (($consultation->questionnaire_responses ?? []) as $key => $value)
                                <div class="d-flex justify-content-between gap-3 py-2 border-bottom">
                                    <dt class="text-muted fw-normal mb-0">{{ \Illuminate\Support\Str::headline($key) }}</dt>
                                    <dd class="fw-semibold text-end mb-0">{{ is_array($value) ? implode(', ', $value) : $value }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-7">
            <div class="panel mb-3">
                <div class="panel-header">
                    <h2 class="h5 mb-1 section-title"><i class="bi bi-telephone-inbound" aria-hidden="true"></i><span>Student call requests</span></h2>
                    <p class="text-muted mb-0">Approve a request to schedule a recorded call room, or decline it.</p>
                </div>

                <div class="list-group list-group-flush">
                    @forelse ($consultation->callRequests()->latest()->get() as $callRequest)
                        <div class="list-group-item px-0">
                            <div class="d-flex flex-wrap justify-content-between gap-3 mb-2">
                                <div>
                                    <span class="fw-semibold">{{ ucfirst($callRequest->call_type) }} call requested</span>
                                    <span class="badge text-bg-secondary ms-2">{{ $callRequest->status }}</span>
                                    <div class="text-muted small">
                                        Preferred: {{ $callRequest->preferred_at ? $callRequest->preferred_at->format('M d, Y g:i A') : 'No preference' }}
                                    </div>
                                </div>
                                <span class="text-muted small">{{ $callRequest->created_at->diffForHumans() }}</span>
                            </div>
                            @if ($callRequest->reason)
                                <p class="mb-3">{{ $callRequest->reason }}</p>
                            @endif

                            @if ($callRequest->status === 'pending')
                                <form method="post" action="{{ route('professional.call-requests.update', $callRequest) }}" class="row g-2 align-items-end">
                                    @csrf
                                    @method('PUT')
                                    <div class="col-12 col-md-5">
                                        <label class="form-label fw-semibold">Scheduled time</label>
                                        <input type="datetime-local" name="scheduled_at" class="form-control" value="{{ $callRequest->preferred_at?->format('Y-m-d\TH:i') }}">
                                    </div>
                                    <div class="col-12 col-md-auto">
                                        <button class="btn btn-primary" type="submit" name="status_action" value="approve">
                                            <i class="bi bi-check2-circle me-1" aria-hidden="true"></i>
                                            Approve
                                        </button>
                                    </div>
                                    <div class="col-12 col-md-auto">
                                        <button class="btn btn-outline-secondary" type="submit" name="status_action" value="decline">
                                            Decline
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    @empty
                        <p class="text-muted mb-0">No student call requests yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="panel mb-3">
                <div class="panel-header">
                    <h2 class="h5 mb-1 section-title"><i class="bi bi-camera-video" aria-hidden="true"></i><span>Recorded call</span></h2>
                    <p class="text-muted mb-0">Create a recorded call room for this consultation. Participants must consent before joining.</p>
                </div>

                <form method="post" action="{{ route('professional.consultations.call-sessions.store', $consultation) }}" class="row g-3 mb-4">
                    @csrf
                    <div class="col-12 col-md-8">
                        <label class="form-label fw-semibold">Scheduled time</label>
                        <input type="datetime-local" name="scheduled_at" class="form-control">
                    </div>
                    <div class="col-12 col-md-4 d-flex align-items-end">
                        <button class="btn btn-primary w-100" type="submit">
                            <i class="bi bi-plus-circle me-1" aria-hidden="true"></i>
                            Create call
                        </button>
                    </div>
                </form>

                <div class="list-group list-group-flush">
                    @forelse ($consultation->callSessions()->latest()->get() as $callSession)
                        <div class="list-group-item px-0 d-flex flex-wrap justify-content-between align-items-center gap-3">
                            <div>
                                <span class="fw-semibold">{{ $callSession->scheduled_at ? $callSession->scheduled_at->format('M d, Y g:i A') : 'Unscheduled call' }}</span>
                                <span class="badge text-bg-secondary ms-2">{{ str_replace('_', ' ', $callSession->status) }}</span>
                                <div class="text-muted small">Recording: {{ str_replace('_', ' ', $callSession->recording?->status ?? 'scheduled') }}</div>
                            </div>
                            <a href="{{ route('call-sessions.show', $callSession) }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-box-arrow-up-right me-1" aria-hidden="true"></i>
                                Open room
                            </a>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No recorded call sessions yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="panel h-100">
                <div class="panel-header">
                    <h2 class="h5 mb-1 section-title"><i class="bi bi-chat-square-heart" aria-hidden="true"></i><span>Structured response</span></h2>
                    <p class="text-muted mb-0">Submit advice, visit guidance, and closing instructions.</p>
                </div>

                <form method="post" action="{{ route('professional.consultations.update', $consultation) }}" class="row g-3">
                    @csrf
                    @method('PUT')
                    <div class="col-12">
                        <label class="form-label fw-semibold">Assessment summary</label>
                        <textarea name="assessment_summary" rows="3" class="form-control">{{ old('assessment_summary', data_get($consultation->recommendation, 'assessment_summary')) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">General advice</label>
                        <textarea name="general_advice" rows="4" class="form-control">{{ old('general_advice', data_get($consultation->recommendation, 'general_advice')) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Pre-visit preparation</label>
                        <textarea name="pre_visit_preparation" rows="3" class="form-control">{{ old('pre_visit_preparation', data_get($consultation->recommendation, 'pre_visit_preparation')) }}</textarea>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Visit recommended</label>
                        <select name="visit_recommended" class="form-select" required>
                            <option value="yes" @selected(data_get($consultation->recommendation, 'visit_recommended') === 'yes')>Yes</option>
                            <option value="no" @selected(data_get($consultation->recommendation, 'visit_recommended') === 'no')>No</option>
                            <option value="urgent" @selected(data_get($consultation->recommendation, 'visit_recommended') === 'urgent')>Urgent</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Priority level</label>
                        <select name="priority_level" class="form-select" required>
                            <option value="routine" @selected(data_get($consultation->recommendation, 'priority_level') === 'routine')>Routine</option>
                            <option value="soon" @selected(data_get($consultation->recommendation, 'priority_level') === 'soon')>Soon</option>
                            <option value="urgent" @selected(data_get($consultation->recommendation, 'priority_level') === 'urgent')>Urgent</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Urgent reason</label>
                        <textarea name="urgent_reason" rows="2" class="form-control">{{ old('urgent_reason', data_get($consultation->recommendation, 'urgent_reason')) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Follow-up instructions</label>
                        <textarea name="follow_up_instructions" rows="3" class="form-control">{{ old('follow_up_instructions', data_get($consultation->recommendation, 'follow_up_instructions')) }}</textarea>
                    </div>
                    <div class="col-12">
                        <div class="row g-2">
                            <div class="col-12 col-md-4">
                                <label class="border rounded-3 p-3 w-100 h-100 d-flex align-items-start gap-2">
                                    <input type="radio" name="status_action" value="save" class="form-check-input mt-1" checked>
                                    <span>
                                        <span class="d-block fw-semibold">Save response</span>
                                        <span class="text-muted small">Mark the case as response ready.</span>
                                    </span>
                                </label>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="border rounded-3 p-3 w-100 h-100 d-flex align-items-start gap-2">
                                    <input type="radio" name="status_action" value="request_info" class="form-check-input mt-1">
                                    <span>
                                        <span class="d-block fw-semibold">Request more info</span>
                                        <span class="text-muted small">Ask the student for clarification.</span>
                                    </span>
                                </label>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="border rounded-3 p-3 w-100 h-100 d-flex align-items-start gap-2">
                                    <input type="radio" name="status_action" value="close" class="form-check-input mt-1">
                                    <span>
                                        <span class="d-block fw-semibold">Close consultation</span>
                                        <span class="text-muted small">End the case after review.</span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex flex-wrap gap-2">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-send me-1" aria-hidden="true"></i>
                            Save recommendation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
