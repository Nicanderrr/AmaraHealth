@extends('layouts.app')

@section('content')
@php
    $replyTotal = $topic->replies->count();
    $lastActivity = $topic->last_reply_at ?: $topic->created_at;
@endphp

@include('partials.page-header', [
    'eyebrow' => 'Forum conversation',
    'title' => $topic->title,
    'description' => $topic->body,
    'actions' => [
        ['label' => 'Back to forum', 'href' => route('forum.index')],
        ['label' => 'Open library', 'href' => route('articles.index'), 'variant' => 'secondary'],
    ],
])

<style>
    .thread-workspace {
        background:
            linear-gradient(180deg, #fff7fa 0%, #ffffff 44%, #fff1f5 100%);
    }
    .thread-layout {
        display: grid;
        gap: 1.6rem;
    }
    .thread-main {
        min-width: 0;
    }
    .thread-panel,
    .thread-side-panel,
    .thread-composer {
        border: 1px solid rgba(159, 18, 57, 0.12);
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.9);
        box-shadow: 0 14px 36px rgba(95, 15, 47, 0.07);
    }
    .thread-panel {
        padding: 1.25rem;
    }
    .thread-kicker,
    .thread-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.55rem;
        color: #9f1239;
        font-size: 0.78rem;
        font-weight: 800;
        text-transform: uppercase;
    }
    .thread-kicker span,
    .thread-meta span {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }
    .thread-kicker span + span::before,
    .thread-meta span + span::before {
        content: "";
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: #fda4af;
    }
    .thread-flag {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        margin-top: 1rem;
        padding: 0.55rem 0.75rem;
        border: 1px solid rgba(217, 119, 6, 0.24);
        border-radius: 8px;
        background: #fff7ed;
        color: #9a3412;
        font-size: 0.88rem;
        font-weight: 800;
        overflow-wrap: anywhere;
    }
    .thread-flag.is-clarified {
        border-color: rgba(22, 163, 74, 0.24);
        background: #f0fdf4;
        color: #166534;
    }
    .thread-question {
        margin-top: 1rem;
    }
    .thread-question h2 {
        margin: 0;
        color: #5f0f2f;
        font-size: clamp(1.45rem, 2.6vw, 2rem);
        line-height: 1.15;
        letter-spacing: 0;
    }
    .thread-question p {
        margin: 0.85rem 0 0;
        color: #334155;
        font-size: 1rem;
        line-height: 1.8;
        white-space: pre-line;
    }
    .thread-section-head {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 1rem;
        margin: 1.8rem 0 1rem;
        padding-bottom: 0.8rem;
        border-bottom: 1px solid rgba(159, 18, 57, 0.12);
    }
    .thread-section-head h2 {
        margin: 0.35rem 0 0;
        color: #5f0f2f;
        font-size: 1.35rem;
        line-height: 1.2;
        letter-spacing: 0;
    }
    .thread-section-head p {
        margin: 0.35rem 0 0;
        color: #64748b;
        line-height: 1.6;
    }
    .thread-timeline {
        display: grid;
        gap: 0.85rem;
        position: relative;
    }
    .thread-reply {
        display: grid;
        grid-template-columns: 42px minmax(0, 1fr);
        gap: 0.9rem;
        align-items: start;
        padding: 1rem;
        border: 1px solid rgba(159, 18, 57, 0.1);
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.86);
    }
    .thread-avatar {
        display: inline-grid;
        place-items: center;
        width: 42px;
        height: 42px;
        border-radius: 8px;
        background: #fff1f5;
        color: #9f1239;
        font-weight: 900;
        text-transform: uppercase;
    }
    .thread-reply__body {
        min-width: 0;
    }
    .thread-reply p {
        margin: 0.55rem 0 0;
        color: #334155;
        line-height: 1.75;
        white-space: pre-line;
    }
    .thread-empty {
        padding: 1.5rem;
        border: 1px dashed rgba(159, 18, 57, 0.22);
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.72);
    }
    .thread-side {
        display: grid;
        gap: 1rem;
        align-content: start;
    }
    .thread-side-panel {
        padding: 1rem;
    }
    .thread-side-panel h3 {
        margin: 0 0 0.75rem;
        color: #5f0f2f;
        font-size: 1rem;
        letter-spacing: 0;
    }
    .thread-facts {
        display: grid;
        gap: 0.65rem;
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .thread-facts li {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.8rem;
        padding: 0.65rem 0;
        border-bottom: 1px solid rgba(159, 18, 57, 0.1);
        color: #64748b;
        font-size: 0.92rem;
    }
    .thread-facts li:last-child {
        border-bottom: 0;
    }
    .thread-facts strong {
        color: #5f0f2f;
        text-align: right;
    }
    .thread-side-panel p {
        margin: 0;
        color: #64748b;
        line-height: 1.6;
    }
    .thread-composer {
        margin-top: 1rem;
        padding: 1.25rem;
    }
    .thread-composer__head {
        display: flex;
        align-items: start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    .thread-composer__head h3 {
        margin: 0.35rem 0 0;
        color: #5f0f2f;
        letter-spacing: 0;
    }
    .thread-composer form {
        display: grid;
        gap: 1rem;
    }
    @media (min-width: 992px) {
        .thread-layout {
            grid-template-columns: minmax(0, 1fr) 320px;
            align-items: start;
        }
        .thread-side {
            position: sticky;
            top: 6rem;
        }
    }
    @media (max-width: 767.98px) {
        .thread-section-head,
        .thread-composer__head {
            flex-direction: column;
            align-items: stretch;
        }
        .thread-reply {
            grid-template-columns: 1fr;
        }
    }
</style>

<section class="section-shell thread-workspace">
    <div class="container">
        <div class="thread-layout">
            <main class="thread-main">
                <article class="thread-panel">
                    <div class="thread-kicker">
                        <span><i class="fas fa-user-secret" aria-hidden="true"></i>{{ $topic->anonymous_name }}</span>
                        <span>Started {{ $topic->created_at->format('j M Y') }}</span>
                        <span>{{ $topic->is_locked ? 'Locked' : 'Open' }}</span>
                        @if ($topic->moderation_status !== 'none')
                            <span>{{ str_replace('_', ' ', $topic->moderation_status) }}</span>
                        @endif
                    </div>
                    <div class="thread-question">
                        <h2>{{ $topic->title }}</h2>
                        @if ($topic->moderation_status !== 'none')
                            <div class="thread-flag {{ $topic->moderation_status === 'clarified' ? 'is-clarified' : '' }}">
                                <i class="fas {{ $topic->moderation_status === 'clarified' ? 'fa-check-circle' : 'fa-flag' }}" aria-hidden="true"></i>
                                <span>
                                    {{ str_replace('_', ' ', $topic->moderation_status) }}
                                    @if ($topic->moderation_reason)
                                        : {{ str_replace('_', ' ', $topic->moderation_reason) }}
                                    @endif
                                </span>
                            </div>
                        @endif
                        <p>{{ $topic->body }}</p>
                    </div>
                </article>

                <div class="thread-section-head">
                    <div>
                        <span class="theme-pill">Replies</span>
                        <h2>Thread responses</h2>
                        <p>Read the conversation in order without the extra decoration.</p>
                    </div>
                    <span class="theme-pill">{{ $replyTotal }} {{ \Illuminate\Support\Str::plural('reply', $replyTotal) }}</span>
                </div>

                <div class="thread-timeline">
                    @forelse ($topic->replies as $reply)
                        <article class="thread-reply">
                            <div class="thread-avatar" aria-hidden="true">
                                {{ \Illuminate\Support\Str::of($reply->anonymous_name)->trim()->substr(0, 1)->upper() ?: 'A' }}
                            </div>
                            <div class="thread-reply__body">
                                <div class="thread-meta">
                                    <span>{{ $reply->anonymous_name }}</span>
                                    <span>{{ $reply->created_at->format('j M Y') }}</span>
                                    <span>{{ $reply->created_at->diffForHumans() }}</span>
                                    @if ($reply->is_professional_clarification)
                                        <span><i class="fas fa-check-circle" aria-hidden="true"></i>Professional clarification</span>
                                    @endif
                                    @if ($reply->moderation_status !== 'none')
                                        <span><i class="fas {{ $reply->moderation_status === 'clarified' ? 'fa-check-circle' : 'fa-flag' }}" aria-hidden="true"></i>{{ str_replace('_', ' ', $reply->moderation_status) }}</span>
                                    @endif
                                </div>
                                @if ($reply->moderation_status !== 'none')
                                    <div class="thread-flag {{ $reply->moderation_status === 'clarified' ? 'is-clarified' : '' }}">
                                        <i class="fas {{ $reply->moderation_status === 'clarified' ? 'fa-check-circle' : 'fa-flag' }}" aria-hidden="true"></i>
                                        <span>
                                            {{ str_replace('_', ' ', $reply->moderation_status) }}
                                            @if ($reply->moderation_reason)
                                                : {{ str_replace('_', ' ', $reply->moderation_reason) }}
                                            @endif
                                        </span>
                                    </div>
                                @endif
                                <p>{{ $reply->body }}</p>
                            </div>
                        </article>
                    @empty
                        <div class="thread-empty">
                            <span class="theme-pill">No replies</span>
                            <h3 class="mt-3 mb-2">No one has replied yet.</h3>
                            <p class="text-muted mb-0">The first useful response will appear here.</p>
                        </div>
                    @endforelse
                </div>

                @auth
                    <section class="thread-composer">
                        <div class="thread-composer__head">
                            <div>
                                <span class="theme-pill">Add reply</span>
                                <h3>Post a response</h3>
                            </div>
                            @if ($topic->is_locked)
                                <span class="theme-pill">Locked discussion</span>
                            @endif
                        </div>

                        <form method="post" action="{{ route('forum.reply', $topic) }}">
                            @csrf
                            <div>
                                <label class="form-label">Alias</label>
                                <input name="anonymous_name" type="text" value="{{ old('anonymous_name') }}" class="form-control theme-input" placeholder="Anonymous Pearl">
                            </div>
                            <div>
                                <label class="form-label">Reply</label>
                                <textarea name="body" rows="5" class="form-control theme-input" required placeholder="Add a helpful, respectful response">{{ old('body') }}</textarea>
                            </div>
                            <button class="thm-btn" @disabled($topic->is_locked)>
                                <span class="thm-btn-text">Post reply</span>
                                <span class="thm-btn-icon-box"><i class="fas fa-arrow-right" aria-hidden="true"></i></span>
                            </button>
                        </form>
                    </section>
                @endauth
            </main>

            <aside class="thread-side">
                <div class="thread-side-panel">
                    <h3>Thread details</h3>
                    <ul class="thread-facts">
                        <li>
                            <span>Status</span>
                            <strong>{{ $topic->is_locked ? 'Locked' : 'Open' }}</strong>
                        </li>
                        @if ($topic->moderation_status !== 'none')
                            <li>
                                <span>Review</span>
                                <strong>{{ str_replace('_', ' ', $topic->moderation_status) }}</strong>
                            </li>
                            @if ($topic->moderation_reason)
                                <li>
                                    <span>Reason</span>
                                    <strong>{{ str_replace('_', ' ', $topic->moderation_reason) }}</strong>
                                </li>
                            @endif
                        @endif
                        <li>
                            <span>Replies</span>
                            <strong>{{ $replyTotal }}</strong>
                        </li>
                        <li>
                            <span>Last activity</span>
                            <strong>{{ optional($lastActivity)->format('j M Y') }}</strong>
                        </li>
                    </ul>
                </div>

                <div class="thread-side-panel">
                    <span class="theme-pill">Privacy note</span>
                    <h3 class="mt-3">Keep personal identifiers out.</h3>
                    <p>Use consultations for private medical details, names, phone numbers, or anything that should not sit in a public discussion.</p>
                    <div class="d-grid gap-2 mt-4">
                        <a href="{{ route('consultations.create') }}" class="thm-btn">
                            <span class="thm-btn-text">Private request</span>
                            <span class="thm-btn-icon-box"><i class="fas fa-arrow-right" aria-hidden="true"></i></span>
                        </a>
                        <a href="{{ route('forum.index') }}" class="thm-btn is-secondary">
                            <span class="thm-btn-text">Back to forum</span>
                            <span class="thm-btn-icon-box"><i class="fas fa-arrow-right" aria-hidden="true"></i></span>
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
