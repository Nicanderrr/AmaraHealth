@extends('layouts.app')

@section('content')
@include('partials.page-header', [
    'eyebrow' => 'Your space',
    'title' => 'Everything personal stays in one calm place',
    'description' => 'Pick up where you left off, from cycle notes and forum threads to consultation updates that need your attention.',
    'actions' => [
        ['label' => 'New request', 'href' => route('consultations.create')],
        ['label' => 'Open tracker', 'href' => route('tracker.index'), 'variant' => 'secondary'],
    ],
])

<section class="container pb-5">
    <div class="stack-grid cols-4">
        <div class="panel-card care-stat p-4">
            <p class="text-muted mb-1">Articles</p>
            <h3 class="m-0">{{ $articleCount }}</h3>
        </div>
        <div class="panel-card care-stat p-4">
            <p class="text-muted mb-1">Resources</p>
            <h3 class="m-0">{{ $resourceCount }}</h3>
        </div>
        <div class="panel-card care-stat p-4">
            <p class="text-muted mb-1">Forum topics</p>
            <h3 class="m-0">{{ $topicCount }}</h3>
        </div>
        <div class="panel-card care-stat p-4">
            <p class="text-muted mb-1">Consultations</p>
            <h3 class="m-0">{{ $consultationCount }}</h3>
        </div>
    </div>
</section>

<section class="container pb-5">
    <div class="stack-grid cols-3">
        <div class="panel-card p-4 p-lg-5">
            <h3 class="mb-3">Next actions</h3>
            <div class="care-surface">
                <a href="{{ route('consultations.create') }}" class="care-card text-decoration-none">
                    <span class="care-card__icon"><i class="fas fa-notes-medical"></i></span>
                    <span class="care-card__body">
                        <strong>Start a private consultation</strong>
                        <span>Share symptoms and get matched to a professional.</span>
                    </span>
                    <i class="fas fa-arrow-right text-muted"></i>
                </a>
                <a href="{{ route('tracker.index') }}" class="care-card text-decoration-none">
                    <span class="care-card__icon"><i class="fas fa-calendar-alt"></i></span>
                    <span class="care-card__body">
                        <strong>Update cycle tracker</strong>
                        <span>Keep predictions and care notes current.</span>
                    </span>
                    <i class="fas fa-arrow-right text-muted"></i>
                </a>
                <a href="{{ route('forum.create') }}" class="care-card text-decoration-none">
                    <span class="care-card__icon"><i class="fas fa-comment-medical"></i></span>
                    <span class="care-card__body">
                        <strong>Ask anonymously</strong>
                        <span>Post without exposing your identity.</span>
                    </span>
                    <i class="fas fa-arrow-right text-muted"></i>
                </a>
            </div>
        </div>

        <div class="panel-card p-4 p-lg-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="m-0">Cycle prediction</h3>
                <a href="{{ route('tracker.index') }}" class="text-decoration-none">Manage entries</a>
            </div>
            @if ($prediction['next_start'])
                <div class="theme-pill mb-3">Predicted next start: {{ $prediction['next_start']->format('j M Y') }}</div>
                <p class="mb-0">Average cycle length: {{ $prediction['average_cycle'] }} days. Average period length: {{ $prediction['average_period'] }} days.</p>
            @else
                <p class="mb-0">Add at least one cycle entry to generate predictions.</p>
            @endif
            <div class="mt-4 stack-grid">
                @forelse ($latestEntries as $entry)
                    <div class="border rounded-4 p-3 soft-divider">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $entry->start_date->format('j M Y') }}</strong>
                            <span>{{ $entry->cycle_length_days ? $entry->cycle_length_days.' days' : 'first record' }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-muted mb-0">No cycle entries yet.</p>
                @endforelse
            </div>
        </div>

        <div class="panel-card p-4 p-lg-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="m-0">Active consultations</h3>
                <a href="{{ route('consultations.index') }}" class="text-decoration-none">View all</a>
            </div>
            <div class="content-list">
                @forelse ($consultations as $consultation)
                    <a class="content-list__item text-decoration-none" href="{{ route('consultations.show', $consultation) }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <strong>{{ $consultation->subject }}</strong>
                            <span class="status-chip">{{ str_replace('_', ' ', $consultation->status) }}</span>
                        </div>
                        <small class="text-muted">Tracking code: {{ $consultation->tracking_code }}</small>
                        <small class="text-muted d-block">
                            Professional:
                            @if ($consultation->assignedProfessional)
                                {{ $consultation->assignedProfessional->display_name ?: $consultation->assignedProfessional->name }}
                            @else
                                Awaiting assignment
                            @endif
                        </small>
                    </a>
                @empty
                    <p class="text-muted mb-0">No requests submitted yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>

<section class="container pb-5">
    <div class="panel-card p-4 p-lg-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="m-0">Anonymous topics</h3>
            <a href="{{ route('forum.create') }}" class="text-decoration-none">Post a topic</a>
        </div>
        <div class="stack-grid cols-2">
            @forelse ($topics as $topic)
                <div class="content-list__item">
                    <div class="d-flex justify-content-between align-items-start gap-3">
                        <div>
                            <strong>{{ $topic->title }}</strong>
                            <div class="text-muted small">{{ $topic->anonymous_name }}</div>
                        </div>
                        <span class="small text-uppercase text-muted">{{ $topic->created_at->format('M j') }}</span>
                    </div>
                </div>
            @empty
                <p class="text-muted mb-0">You have not posted anonymously yet.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
