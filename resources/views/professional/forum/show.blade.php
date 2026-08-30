@extends('layouts.admin')

@php
    $pageTitle = 'Professional forum review';
    $subtitle = 'Clarify public discussion and mark reviewed misinformation concerns.';
    $statusOptions = [
        'needs_professional_review' => 'Needs professional review',
        'reviewed' => 'Reviewed',
        'clarified' => 'Clarified',
    ];
@endphp

@section('page-actions')
    <a href="{{ route('professional.forum.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-2" aria-hidden="true"></i>Review queue
    </a>
@endsection

@section('content')
    <style>
        .review-layout {
            display: grid;
            gap: 0.9rem;
        }
        .review-item {
            border: 1px solid var(--admin-border);
            border-radius: 8px;
            background: var(--admin-surface);
            box-shadow: var(--admin-shadow);
            padding: 1.2rem;
            min-width: 0;
            overflow: hidden;
        }
        .review-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.75rem;
        }
        .review-title {
            min-width: 0;
            flex: 1 1 280px;
        }
        .review-badges {
            flex: 0 1 auto;
            justify-content: flex-end;
        }
        .review-meta {
            display: flex;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 0.55rem;
            color: var(--admin-muted);
            font-size: 0.86rem;
            font-weight: 700;
        }
        .review-item h2,
        .review-body {
            overflow-wrap: anywhere;
            word-break: break-word;
        }
        .review-body {
            color: var(--admin-text);
            line-height: 1.7;
            white-space: pre-line;
        }
        .review-form-grid {
            display: grid;
            gap: 0.8rem;
            margin-top: 1rem;
            align-items: end;
        }
        .review-form-grid > *,
        .review-contact-panel,
        .review-contact-panel .form-control {
            min-width: 0;
        }
        .review-side-panel {
            align-self: start;
        }
        @media (min-width: 992px) {
            .review-form-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .review-form-grid .wide {
                grid-column: 1 / -1;
            }
        }
        @media (min-width: 1200px) {
            .review-side-panel {
                position: sticky;
                top: 1rem;
            }
        }
        @media (max-width: 575.98px) {
            .review-item {
                padding: 1rem;
            }
            .review-header {
                display: grid;
            }
            .review-badges {
                justify-content: flex-start;
            }
            .review-form-grid .btn,
            .review-contact-panel .btn {
                width: 100%;
            }
        }
    </style>

    <section class="row g-3 mt-1">
        <div class="col-12 col-xl-8">
            <article class="review-item">
                <div class="review-header">
                    <div class="review-title">
                        <div class="review-meta">
                            <span>{{ $topic->anonymous_name }}</span>
                            <span>{{ optional($topic->created_at)->format('M d, Y') }}</span>
                            <span>{{ $topic->replies->count() }} replies</span>
                        </div>
                        <h2 class="h4 mt-2 mb-0">{{ $topic->title }}</h2>
                    </div>
                    <div class="review-badges d-flex flex-wrap gap-2">
                        <span class="badge {{ $topic->is_locked ? 'text-bg-dark' : 'text-bg-success' }}">{{ $topic->is_locked ? 'Locked' : 'Open' }}</span>
                        @if ($topic->is_hidden)
                            <span class="badge text-bg-danger">Hidden by admin</span>
                        @endif
                        @if ($topic->moderation_status !== 'none')
                            <span class="badge text-bg-warning">{{ str_replace('_', ' ', $topic->moderation_status) }}</span>
                        @endif
                    </div>
                </div>

                <p class="review-body mt-3 mb-0">{{ $topic->body }}</p>

                <form method="post" action="{{ route('professional.forum.moderate-topic', $topic) }}" class="review-form-grid">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label class="form-label">Review status</label>
                        <select name="moderation_status" class="form-select">
                            @foreach ($statusOptions as $value => $label)
                                <option value="{{ $value }}" @selected($topic->moderation_status === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Reason</label>
                        <select name="moderation_reason" class="form-select">
                            @foreach ($flagReasons as $value => $label)
                                <option value="{{ $value }}" @selected(($topic->moderation_reason ?? 'needs_clarification') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="wide">
                        <label class="form-label">Professional note</label>
                        <textarea name="moderation_note" rows="3" class="form-control">{{ $topic->moderation_note }}</textarea>
                    </div>
                    <div class="wide text-lg-end">
                        <button class="btn btn-primary" type="submit"><i class="bi bi-check2-circle me-2" aria-hidden="true"></i>Save review</button>
                    </div>
                </form>
            </article>

            <section class="panel mt-3">
                <div class="panel-header">
                    <div>
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-patch-check" aria-hidden="true"></i><span>Post clarification</span></h2>
                        <p class="text-muted mb-0">This appears publicly in the thread with a professional clarification badge.</p>
                    </div>
                </div>
                <form method="post" action="{{ route('professional.forum.clarify', $topic) }}" class="d-grid gap-3">
                    @csrf
                    <textarea name="body" rows="5" class="form-control" required placeholder="Correct misinformation, explain the safer next step, or clarify what needs medical care."></textarea>
                    <button class="btn btn-primary" type="submit" @disabled($topic->is_locked)>
                        <i class="bi bi-send me-2" aria-hidden="true"></i>Post professional clarification
                    </button>
                </form>
            </section>

            <section class="panel mt-3">
                <div class="panel-header">
                    <div>
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-chat-dots" aria-hidden="true"></i><span>Replies</span></h2>
                        <p class="text-muted mb-0">Review the replies that shaped this discussion.</p>
                    </div>
                </div>

                <div class="review-layout">
                    @forelse ($topic->replies as $reply)
                        <article class="review-item">
                            <div class="review-header">
                                <div class="review-meta review-title">
                                    <span>{{ $reply->anonymous_name }}</span>
                                    <span>{{ optional($reply->created_at)->format('M d, Y') }}</span>
                                    @if ($reply->is_professional_clarification)
                                        <span class="badge text-bg-info">Professional clarification</span>
                                    @endif
                                </div>
                                <div class="review-badges d-flex flex-wrap gap-2">
                                    @if ($reply->is_hidden)
                                        <span class="badge text-bg-danger">Hidden by admin</span>
                                    @endif
                                    @if ($reply->moderation_status !== 'none')
                                        <span class="badge text-bg-warning">{{ str_replace('_', ' ', $reply->moderation_status) }}</span>
                                    @endif
                                </div>
                            </div>

                            <p class="review-body mt-3 mb-0">{{ $reply->body }}</p>

                            <form method="post" action="{{ route('professional.forum.moderate-reply', [$topic, $reply]) }}" class="review-form-grid">
                                @csrf
                                @method('PATCH')
                                <div>
                                    <label class="form-label">Review status</label>
                                    <select name="moderation_status" class="form-select">
                                        @foreach ($statusOptions as $value => $label)
                                            <option value="{{ $value }}" @selected(in_array($reply->moderation_status, ['none', 'flagged'], true) ? $value === 'needs_professional_review' : $reply->moderation_status === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label">Reason</label>
                                    <select name="moderation_reason" class="form-select">
                                        @foreach ($flagReasons as $value => $label)
                                            <option value="{{ $value }}" @selected(($reply->moderation_reason ?? 'needs_clarification') === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="wide">
                                    <label class="form-label">Professional note</label>
                                    <textarea name="moderation_note" rows="3" class="form-control">{{ $reply->moderation_note }}</textarea>
                                </div>
                                <div class="wide text-lg-end">
                                    <button class="btn btn-primary" type="submit"><i class="bi bi-check2-circle me-2" aria-hidden="true"></i>Save reply review</button>
                                </div>
                            </form>
                        </article>
                    @empty
                        <p class="text-muted mb-0">No replies yet.</p>
                    @endforelse
                </div>
            </section>
        </div>

        <div class="col-12 col-xl-4">
            <aside class="panel review-side-panel">
                <div class="panel-header">
                    <div>
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-person-vcard" aria-hidden="true"></i><span>Private contact</span></h2>
                        <p class="text-muted mb-0">Contact the linked user through the system if follow-up is needed.</p>
                    </div>
                </div>

                <form method="post" action="{{ route('professional.forum.contact-topic-author', $topic) }}" class="review-contact-panel">
                    @csrf
                    <label class="form-label">Message to topic author</label>
                    <textarea name="message" rows="5" class="form-control" placeholder="{{ $topic->user_id ? 'Invite them to a private consultation or give next steps.' : 'No linked account for this topic.' }}" @disabled(! $topic->user_id)></textarea>
                    <button class="btn btn-outline-secondary mt-3 w-100" type="submit" @disabled(! $topic->user_id)>
                        <i class="bi bi-send me-2" aria-hidden="true"></i>Contact user
                    </button>
                </form>
            </aside>
        </div>
    </section>
@endsection
