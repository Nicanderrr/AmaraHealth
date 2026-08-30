@extends('layouts.admin')

@php
    $pageTitle = 'Consultations';
    $subtitle = 'Review requests and publish preparation guidance.';

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

@section('content')
    <section class="panel">
        <div class="panel-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-inbox" aria-hidden="true"></i><span>Consultation queue</span></h2>
                <p class="text-muted mb-0">Open each ticket, review the concern, and record the response.</p>
            </div>
            <span class="badge rounded-pill text-bg-light border">{{ $requests->total() }} requests</span>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th scope="col">Tracking</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Concern</th>
                        <th scope="col">Professional</th>
                        <th scope="col">Status</th>
                        <th scope="col">Created</th>
                        <th scope="col" class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($requests as $request)
                        <tr>
                            <td class="fw-semibold">{{ $request->tracking_code }}</td>
                            <td>
                                <div class="fw-semibold">{{ $request->subject }}</div>
                                <div class="text-muted small">{{ $request->concern_type }}</div>
                            </td>
                            <td>{{ $request->concern_type }}</td>
                            <td>
                                @if ($request->assignedProfessional)
                                    <div class="fw-semibold">{{ $request->assignedProfessional->display_name ?: $request->assignedProfessional->name }}</div>
                                    @if ($request->assignedProfessional->professional_title)
                                        <div class="text-muted small">{{ $request->assignedProfessional->professional_title }}</div>
                                    @endif
                                @else
                                    <span class="text-muted">Awaiting assignment</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $statusClass[$request->status] ?? 'text-bg-secondary' }}">{{ str_replace('_', ' ', $request->status) }}</span>
                            </td>
                            <td class="text-muted">{{ optional($request->created_at)->diffForHumans() }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.consultations.show', $request) }}" class="btn btn-light btn-sm">Open</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No consultation requests found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $requests->links() }}</div>
    </section>
@endsection
