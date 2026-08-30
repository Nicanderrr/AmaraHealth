@extends('layouts.app')

@section('content')
@php
    $entryCollection = collect($entries->items());
    $latestEntry = $entryCollection->first();
    $averageCycle = $entryCollection->filter(fn ($entry) => ! is_null($entry->cycle_length_days))->avg('cycle_length_days');
@endphp

@include('partials.page-header', [
    'breadcrumbLabel' => 'Tracker',
    'eyebrow' => 'Body notes',
    'title' => 'Spot the pattern your memory might miss',
    'description' => 'Save period dates, flow changes, symptoms, and notes in a private timeline that can support better care decisions.',
    'actions' => [
        ['label' => 'Open library', 'href' => route('articles.index')],
        ['label' => 'Ask anonymously', 'href' => route('forum.index'), 'variant' => 'secondary'],
    ],
    'metrics' => [
        ['label' => 'Entries saved', 'value' => $entries->total(), 'note' => 'Private records in your timeline'],
        ['label' => 'Usual rhythm', 'value' => $averageCycle ? number_format($averageCycle, 1) . ' days' : 'N/A', 'note' => 'Average from your saved cycles'],
        ['label' => 'Last noted', 'value' => $latestEntry?->start_date?->format('M j') ?? 'None', 'note' => 'Most recent period start'],
    ],
    'metricLayout' => 'carousel',
])

<section class="section-shell">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5">
                <div class="tracker-card h-100">
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-4">
                        <div>
                            <span class="theme-pill">New entry</span>
                            <h3 class="mt-3 mb-0">Add a cycle record</h3>
                        </div>
                        <span class="text-uppercase small text-muted">Private</span>
                    </div>
                    <form method="post" action="{{ route('tracker.store') }}" class="stack-grid">
                        @csrf
                        <div>
                            <label class="form-label">Start date</label>
                            <input type="date" name="start_date" class="form-control theme-input" required>
                        </div>
                        <div>
                            <label class="form-label">End date</label>
                            <input type="date" name="end_date" class="form-control theme-input">
                        </div>
                        <div>
                            <label class="form-label">Flow level</label>
                            <select name="flow_level" class="form-select theme-input">
                                <option value="">Select flow</option>
                                <option value="light">Light</option>
                                <option value="medium">Medium</option>
                                <option value="heavy">Heavy</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Notes</label>
                            <textarea name="notes" rows="4" class="form-control theme-input" placeholder="Pain, symptoms, reminders, or anything useful later"></textarea>
                        </div>
                        <button class="thm-btn">
                            <span class="thm-btn-text">Save entry</span>
                            <span class="thm-btn-icon-box"><i class="fas fa-arrow-right"></i></span>
                        </button>
                    </form>
                </div>

                <div class="info-panel mt-4">
                    <span class="info-panel__eyebrow">Tracking tips</span>
                    <h3 class="info-panel__title">Keep the record simple.</h3>
                    <ul class="info-panel__list">
                        <li>
                            <div class="icon"><i class="fas fa-calendar-day"></i></div>
                            <div>
                                <strong>Record start dates</strong>
                                <p>Adding the start date consistently makes patterns easier to read later.</p>
                            </div>
                        </li>
                        <li>
                            <div class="icon"><i class="fas fa-notes-medical"></i></div>
                            <div>
                                <strong>Capture symptoms</strong>
                                <p>Short notes help you explain changes more clearly during a consultation.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="tracker-card h-100">
                    <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center mb-4">
                        <div>
                            <span class="theme-pill">Saved history</span>
                            <h3 class="mt-3 mb-0">Recent cycle entries</h3>
                        </div>
                        <span class="text-uppercase small text-muted">{{ $entries->total() }} total records</span>
                    </div>

                    <div class="stack-grid">
                        @forelse ($entries as $entry)
                            <article class="article-card">
                                <div class="article-card__meta">
                                    <span class="theme-pill">{{ $entry->start_date->format('j M Y') }}</span>
                                    <span class="theme-pill">{{ $entry->flow_level ?? 'No flow set' }}</span>
                                </div>
                                <h3 class="article-card__title mb-0">Cycle length: {{ $entry->cycle_length_days ? $entry->cycle_length_days . ' days' : 'first recorded entry' }}</h3>
                                <p class="article-card__text mt-2">
                                    Ends {{ $entry->end_date?->format('j M Y') ?? 'not recorded' }}.
                                    @if ($entry->period_length_days)
                                        Period length: {{ $entry->period_length_days }} days.
                                    @endif
                                </p>
                                @if ($entry->notes)
                                    <div class="mt-3 p-3 rounded-4" style="background: rgba(159, 18, 57, 0.05);">
                                        <small class="text-uppercase text-muted">Notes</small>
                                        <p class="mb-0 mt-2">{{ $entry->notes }}</p>
                                    </div>
                                @endif
                            </article>
                        @empty
                            <div class="panel-card p-4">
                                <p class="mb-0 text-muted">No entries saved yet.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-4">{{ $entries->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
