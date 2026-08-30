@extends('layouts.app')

@section('content')
@php
    $topicCollection = collect($topics->items());
    $replyCount = $topicCollection->sum('replies_count');
    $activeTopic = $topicCollection->first();
@endphp

@include('partials.page-header', [
    'breadcrumbLabel' => 'Forum',
    'eyebrow' => 'Anonymous forum',
    'title' => 'The questions people whisper belong here too',
    'description' => 'Use an alias, read what others are asking, and get support without making your identity part of the conversation.',
    'actions' => auth()->check() ? [
        ['label' => 'Start topic', 'href' => route('forum.create')],
        ['label' => 'Dashboard', 'href' => route('dashboard'), 'variant' => 'secondary'],
    ] : [
        ['label' => 'Create account', 'href' => route('register')],
    ],
    'metrics' => [
        ['label' => 'Open conversations', 'value' => $topics->count(), 'note' => 'Recent questions from students'],
        ['label' => 'Replies shared', 'value' => $replyCount, 'note' => 'Support happening in the feed'],
        ['label' => 'Latest post', 'value' => $activeTopic?->created_at?->format('M j') ?? 'None', 'note' => 'Newest question added'],
    ],
    'metricLayout' => 'carousel',
])

<style>
    .forum-workspace {
        background:
            linear-gradient(180deg, #fff7fa 0%, #ffffff 42%, #fff1f5 100%);
    }
    .forum-layout {
        display: grid;
        gap: 1.6rem;
    }
    .forum-toolbar {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(159, 18, 57, 0.12);
    }
    .forum-toolbar h2 {
        margin: 0;
        color: #5f0f2f;
        font-size: clamp(1.5rem, 2.5vw, 2.1rem);
        line-height: 1.12;
        letter-spacing: 0;
    }
    .forum-toolbar p {
        max-width: 40rem;
        margin: 0.55rem 0 0;
        color: #64748b;
        line-height: 1.7;
    }
    .forum-feed {
        display: grid;
        gap: 0.8rem;
    }
    .forum-topic-row {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 1.2rem;
        align-items: center;
        padding: 1rem 1.1rem;
        border: 1px solid rgba(159, 18, 57, 0.12);
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.88);
        box-shadow: 0 12px 32px rgba(95, 15, 47, 0.06);
        transition: border-color 0.18s ease, box-shadow 0.18s ease, transform 0.18s ease;
    }
    .forum-topic-row:hover,
    .forum-topic-row:focus-within {
        border-color: rgba(225, 29, 72, 0.34);
        box-shadow: 0 16px 42px rgba(95, 15, 47, 0.09);
        transform: translateY(-2px);
    }
    .forum-topic-row__body {
        min-width: 0;
    }
    .forum-topic-row__meta,
    .forum-topic-row__stats {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.55rem;
    }
    .forum-topic-row__meta {
        margin-bottom: 0.45rem;
        color: #9f1239;
        font-size: 0.78rem;
        font-weight: 800;
        text-transform: uppercase;
    }
    .forum-topic-row__meta span {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }
    .forum-topic-row__meta span + span::before {
        content: "";
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: #fda4af;
    }
    .forum-topic-row h3 {
        margin: 0;
        color: #5f0f2f;
        font-size: 1.08rem;
        line-height: 1.25;
        letter-spacing: 0;
    }
    .forum-topic-row h3 a {
        color: inherit;
    }
    .forum-topic-row h3 a:hover {
        color: #be123c;
    }
    .forum-topic-row p {
        margin: 0.55rem 0 0;
        color: #64748b;
        line-height: 1.65;
    }
    .forum-topic-row__side {
        display: grid;
        gap: 0.7rem;
        justify-items: end;
        min-width: 132px;
    }
    .forum-topic-row__stats {
        justify-content: flex-end;
    }
    .forum-stat-chip,
    .forum-state-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        min-height: 32px;
        padding: 0.35rem 0.65rem;
        border-radius: 999px;
        font-size: 0.82rem;
        font-weight: 800;
        white-space: nowrap;
    }
    .forum-stat-chip {
        border: 1px solid rgba(159, 18, 57, 0.12);
        background: #fff1f5;
        color: #9f1239;
    }
    .forum-state-chip {
        border: 1px solid rgba(190, 18, 60, 0.2);
        background: #ffe4ec;
        color: #be123c;
    }
    .forum-state-chip.is-review {
        border-color: rgba(217, 119, 6, 0.28);
        background: #fff7ed;
        color: #9a3412;
    }
    .forum-state-chip.is-clarified {
        border-color: rgba(22, 163, 74, 0.24);
        background: #f0fdf4;
        color: #166534;
    }
    .forum-open-link {
        display: inline-grid;
        place-items: center;
        width: 38px;
        height: 38px;
        border-radius: 8px;
        background: #9f1239;
        color: #fff;
        box-shadow: 0 10px 20px rgba(159, 18, 57, 0.18);
    }
    .forum-open-link:hover {
        background: #be123c;
        color: #fff;
    }
    .forum-side {
        display: grid;
        gap: 1rem;
        align-content: start;
    }
    .forum-side-panel {
        padding: 1rem;
        border: 1px solid rgba(159, 18, 57, 0.12);
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.9);
        box-shadow: 0 14px 36px rgba(95, 15, 47, 0.07);
    }
    .forum-side-panel h3 {
        margin: 0 0 0.75rem;
        color: #5f0f2f;
        font-size: 1rem;
        letter-spacing: 0;
    }
    .forum-guideline-list {
        display: grid;
        gap: 0.75rem;
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .forum-guideline-list li {
        display: grid;
        grid-template-columns: 34px minmax(0, 1fr);
        gap: 0.7rem;
        align-items: start;
    }
    .forum-guideline-list .icon {
        display: inline-grid;
        place-items: center;
        width: 34px;
        height: 34px;
        border-radius: 8px;
        background: #fff1f5;
        color: #9f1239;
    }
    .forum-guideline-list strong {
        display: block;
        color: #5f0f2f;
        font-size: 0.92rem;
    }
    .forum-guideline-list p,
    .forum-side-panel p {
        margin: 0.15rem 0 0;
        color: #64748b;
        font-size: 0.92rem;
        line-height: 1.55;
    }
    .forum-empty {
        padding: 2rem;
        border: 1px solid rgba(159, 18, 57, 0.12);
        border-radius: 8px;
        background: #fff;
    }
    @media (min-width: 992px) {
        .forum-layout {
            grid-template-columns: minmax(0, 1fr) 320px;
            align-items: start;
        }
        .forum-side {
            position: sticky;
            top: 6rem;
        }
    }
    @media (max-width: 767.98px) {
        .forum-toolbar {
            align-items: stretch;
            flex-direction: column;
        }
        .forum-topic-row {
            grid-template-columns: 1fr;
        }
        .forum-topic-row__side {
            min-width: 0;
            justify-items: start;
        }
        .forum-topic-row__stats {
            justify-content: flex-start;
        }
    }
</style>

<section class="section-shell forum-workspace">
    <div class="container">
        <div class="forum-layout">
            <div>
                <div class="forum-toolbar">
                    <div>
                        <span class="theme-pill">Latest discussions</span>
                        <h2>Browse the room without the noise</h2>
                        <p>Scan recent anonymous questions, see what has replies, and open only the conversations that feel relevant.</p>
                    </div>
                    @auth
                        <a href="{{ route('forum.create') }}" class="thm-btn">
                            <span class="thm-btn-text">Start topic</span>
                            <span class="thm-btn-icon-box"><i class="fas fa-arrow-right" aria-hidden="true"></i></span>
                        </a>
                    @endauth
                </div>

                <div class="forum-feed mt-4">
                    @forelse ($topics as $topic)
                        @php
                            $activityDate = $topic->last_reply_at ?: $topic->created_at;
                        @endphp
                        <article class="forum-topic-row">
                            <div class="forum-topic-row__body">
                                <div class="forum-topic-row__meta">
                                    <span><i class="fas fa-user-secret" aria-hidden="true"></i>{{ $topic->anonymous_name }}</span>
                                    <span>{{ optional($activityDate)->diffForHumans() }}</span>
                                </div>
                                <h3>
                                    <a href="{{ route('forum.show', $topic) }}">{{ $topic->title }}</a>
                                </h3>
                                <p>{{ \Illuminate\Support\Str::limit($topic->body, 170) }}</p>
                            </div>
                            <div class="forum-topic-row__side">
                                <div class="forum-topic-row__stats">
                                    <span class="forum-stat-chip">
                                        <i class="fas fa-comment-dots" aria-hidden="true"></i>
                                        {{ $topic->replies_count }} {{ \Illuminate\Support\Str::plural('reply', $topic->replies_count) }}
                                    </span>
                                    @if ($topic->is_locked)
                                        <span class="forum-state-chip">
                                            <i class="fas fa-lock" aria-hidden="true"></i>
                                            Locked
                                        </span>
                                    @else
                                        <span class="forum-state-chip">
                                            <i class="fas fa-unlock" aria-hidden="true"></i>
                                            Open
                                        </span>
                                    @endif
                                    @if ($topic->moderation_status !== 'none')
                                        <span class="forum-state-chip {{ $topic->moderation_status === 'clarified' ? 'is-clarified' : 'is-review' }}">
                                            <i class="fas {{ $topic->moderation_status === 'clarified' ? 'fa-check-circle' : 'fa-flag' }}" aria-hidden="true"></i>
                                            {{ str_replace('_', ' ', $topic->moderation_status) }}
                                        </span>
                                    @endif
                                </div>
                                <a href="{{ route('forum.show', $topic) }}" class="forum-open-link" aria-label="Open {{ $topic->title }}">
                                    <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                </a>
                            </div>
                        </article>
                    @empty
                        <div class="forum-empty">
                            <span class="theme-pill">No topics</span>
                            <h2 class="mt-3 mb-2">No forum topics yet.</h2>
                            <p class="text-muted mb-0">When someone starts a discussion, it will appear here.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">{{ $topics->links() }}</div>
            </div>

            <aside class="forum-side">
                <div class="forum-side-panel">
                    <h3>Posting basics</h3>
                    <ul class="forum-guideline-list">
                        <li>
                            <div class="icon"><i class="fas fa-user-secret" aria-hidden="true"></i></div>
                            <div>
                                <strong>Use an alias</strong>
                                <p>Keep identifying details out of your question.</p>
                            </div>
                        </li>
                        <li>
                            <div class="icon"><i class="fas fa-notes-medical" aria-hidden="true"></i></div>
                            <div>
                                <strong>Be specific</strong>
                                <p>Symptoms, timing, and context help people respond clearly.</p>
                            </div>
                        </li>
                        <li>
                            <div class="icon"><i class="fas fa-shield-alt" aria-hidden="true"></i></div>
                            <div>
                                <strong>Stay respectful</strong>
                                <p>Moderators can lock conversations that become unsafe.</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="forum-side-panel">
                    <span class="theme-pill">Next step</span>
                    <h3 class="mt-3">Need private support?</h3>
                    <p>Use consultations for personal details that should not be posted in the forum.</p>
                    <div class="d-grid gap-2 mt-4">
                        @auth
                            <a href="{{ route('forum.create') }}" class="thm-btn">
                                <span class="thm-btn-text">Start topic</span>
                                <span class="thm-btn-icon-box"><i class="fas fa-arrow-right" aria-hidden="true"></i></span>
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="thm-btn">
                                <span class="thm-btn-text">Create account</span>
                                <span class="thm-btn-icon-box"><i class="fas fa-arrow-right" aria-hidden="true"></i></span>
                            </a>
                        @endauth
                        <a href="{{ route('consultations.create') }}" class="thm-btn is-secondary">
                            <span class="thm-btn-text">Private request</span>
                            <span class="thm-btn-icon-box"><i class="fas fa-arrow-right" aria-hidden="true"></i></span>
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
