@extends('layouts.admin')

@php
    $pageTitle = 'Consultation queue';
    $subtitle = 'All consultations assigned to you.';

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
        <div class="panel-header">
            <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-heart-pulse" aria-hidden="true"></i><span>Assigned consultations</span></h2>
                <p class="text-muted mb-0">Open cases by newest assignment first.</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th scope="col">Tracking</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Category</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($consultations as $consultation)
                        <tr>
                            <td class="fw-semibold">{{ $consultation->tracking_code }}</td>
                            <td class="fw-semibold">{{ $consultation->subject }}</td>
                            <td>{{ $consultation->concern_category }}</td>
                            <td>
                                <span class="badge {{ $statusClass[$consultation->status] ?? 'text-bg-secondary' }}">{{ str_replace('_', ' ', $consultation->status) }}</span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('professional.consultations.show', $consultation) }}" class="btn btn-light btn-sm">Open</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No assigned consultations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $consultations->links() }}</div>
    </section>
@endsection
