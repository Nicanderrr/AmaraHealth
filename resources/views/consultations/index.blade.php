@extends('layouts.app')

@section('content')
@include('partials.page-header', [
    'eyebrow' => 'Care requests',
    'title' => 'Follow every concern from sent to answered',
    'description' => 'Check tracking codes, professional responses, call requests, and follow-up without losing the thread.',
    'actions' => [
        ['label' => 'New request', 'href' => route('consultations.create')],
    ],
])

<section class="container pb-5">
    <div class="content-list">
        @forelse ($requests as $request)
            <a href="{{ route('consultations.show', $request) }}" class="content-list__item text-decoration-none">
                <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                    <div class="d-flex align-items-start gap-3">
                        <span class="care-card__icon"><i class="fas fa-heartbeat"></i></span>
                        <div>
                            <span class="theme-pill">{{ $request->tracking_code }}</span>
                            <h3 class="h5 mt-3 mb-1">{{ $request->subject }}</h3>
                            <p class="mb-0 text-muted">{{ $request->concern_type }}</p>
                            <p class="mb-0 text-muted small">
                                Assigned professional:
                                @if ($request->assignedProfessional)
                                    {{ $request->assignedProfessional->display_name ?: $request->assignedProfessional->name }}
                                    @if ($request->assignedProfessional->professional_title)
                                        ({{ $request->assignedProfessional->professional_title }})
                                    @endif
                                @else
                                    Awaiting assignment
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="status-chip">{{ str_replace('_', ' ', $request->status) }}</span>
                        <div class="small text-muted mt-2">{{ optional($request->updated_at)->diffForHumans() }}</div>
                    </div>
                </div>
            </a>
        @empty
            <div class="panel-card p-4 p-lg-5 text-center">
                <h3>No consultation requests yet</h3>
                <p class="text-muted">Start with a private intake. You can request a call after submitting.</p>
                <a href="{{ route('consultations.create') }}" class="thm-btn thm-btn--sm">
                    <span class="thm-btn-text">New request</span>
                </a>
            </div>
        @endforelse
    </div>
    <div class="mt-4">{{ $requests->links() }}</div>
</section>
@endsection
