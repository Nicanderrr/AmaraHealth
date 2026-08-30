@extends('layouts.admin')

@php
    $pageTitle = 'Forum topic review';
    $subtitle = 'Review the full discussion, flag risky content, and contact linked users.';
    $statusOptions = [
        'none' => 'No flag',
        'flagged' => 'Flagged',
        'needs_professional_review' => 'Needs professional review',
        'reviewed' => 'Reviewed',
        'clarified' => 'Clarified',
    ];
@endphp

@section('page-actions')
    <a href="{{ route('admin.forum.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-2" aria-hidden="true"></i>Forum queue
    </a>
@endsection

@section('content')
    <style>
        .moderation-layout {
            display: grid;
            gap: 0.9rem;
        }
        .moderation-item {
            border: 1px solid var(--admin-border);
            border-radius: 8px;
            background: var(--admin-surface);
            box-shadow: var(--admin-shadow);
            padding: 1.2rem;
            min-width: 0;
            overflow: hidden;
        }
        .moderation-item__header,
        .moderation-item__meta {
            display: flex;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 0.55rem;
        }
        .moderation-item__header {
            justify-content: space-between;
            margin-bottom: 0.9rem;
        }
        .moderation-item__title {
            min-width: 0;
            flex: 1 1 280px;
        }
        .moderation-item__badges {
            flex: 0 1 auto;
            justify-content: flex-end;
        }
        .moderation-item h2,
        .moderation-body,
        .moderation-account-list dd {
            overflow-wrap: anywhere;
            word-break: break-word;
        }
        .moderation-item__meta {
            color: var(--admin-muted);
            font-size: 0.86rem;
            font-weight: 700;
        }
        .moderation-body {
            color: var(--admin-text);
            line-height: 1.7;
            white-space: pre-line;
        }
        .moderation-form-grid {
            display: grid;
            gap: 0.8rem;
            margin-top: 1rem;
            align-items: end;
        }
        .moderation-form-grid > *,
        .moderation-contact .input-group,
        .moderation-contact .form-control {
            min-width: 0;
        }
        .moderation-action-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            flex-wrap: wrap;
        }
        .moderation-side-panel {
            align-self: start;
        }
        @media (min-width: 992px) {
            .moderation-form-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .moderation-form-grid .wide {
                grid-column: 1 / -1;
            }
        }
        @media (min-width: 1200px) {
            .moderation-side-panel {
                position: sticky;
                top: 1rem;
            }
        }
        @media (max-width: 575.98px) {
            .moderation-item {
                padding: 1rem;
            }
            .moderation-item__header {
                display: grid;
            }
            .moderation-item__badges {
                justify-content: flex-start;
            }
            .moderation-action-row .btn {
                width: 100%;
            }
        }
    </style>

    <section class="row g-3 mt-1">
        <div class="col-12 col-xl-8">
            <article class="moderation-item">
                <div class="moderation-item__header">
                    <div class="moderation-item__title">
                        <div class="moderation-item__meta">
                            <span>{{ $topic->anonymous_name }}</span>
                            <span>{{ optional($topic->created_at)->format('M d, Y') }}</span>
                            <span>{{ $topic->replies->count() }} replies</span>
                        </div>
                        <h2 class="h4 mt-2 mb-0">{{ $topic->title }}</h2>
                    </div>
                    <div class="moderation-item__badges d-flex flex-wrap gap-2">
                        <span class="badge {{ $topic->is_locked ? 'text-bg-dark' : 'text-bg-success' }}">{{ $topic->is_locked ? 'Locked' : 'Open' }}</span>
                        @if ($topic->is_hidden)
                            <span class="badge text-bg-danger">Hidden</span>
                        @endif
                        @if ($topic->moderation_status !== 'none')
                            <span class="badge text-bg-warning">{{ str_replace('_', ' ', $topic->moderation_status) }}</span>
                        @endif
                    </div>
                </div>

                <p class="moderation-body mb-0">{{ $topic->body }}</p>

                <form method="post" action="{{ route('admin.forum.moderate-topic', $topic) }}" class="moderation-form-grid">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label class="form-label">Status</label>
                        <select name="moderation_status" class="form-select">
                            @foreach ($statusOptions as $value => $label)
                                <option value="{{ $value }}" @selected(old('moderation_status', $topic->moderation_status) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Reason</label>
                        <select name="moderation_reason" class="form-select">
                            @foreach ($flagReasons as $value => $label)
                                <option value="{{ $value }}" @selected(old('moderation_reason', $topic->moderation_reason ?? 'needs_clarification') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="wide">
                        <label class="form-label">Internal note</label>
                        <textarea name="moderation_note" rows="3" class="form-control">{{ old('moderation_note', $topic->moderation_note) }}</textarea>
                    </div>
                    <div class="wide moderation-action-row">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="is_hidden" id="topic-hidden" @checked(old('is_hidden', $topic->is_hidden))>
                            <label class="form-check-label" for="topic-hidden">Hide from public forum</label>
                        </div>
                        <button class="btn btn-primary" type="submit"><i class="bi bi-flag me-2" aria-hidden="true"></i>Save topic review</button>
                    </div>
                </form>

                <form method="post" action="{{ route('admin.forum.contact-topic-author', $topic) }}" class="moderation-contact mt-3">
                    @csrf
                    <label class="form-label">Contact topic author</label>
                    <div class="input-group">
                        <input name="message" class="form-control" placeholder="{{ $topic->user_id ? 'Message sent as a private notification' : 'No linked account for this topic' }}" @disabled(! $topic->user_id)>
                        <button class="btn btn-outline-secondary" type="submit" @disabled(! $topic->user_id) title="Contact user" aria-label="Contact user">
                            <i class="bi bi-send" aria-hidden="true"></i>
                        </button>
                    </div>
                </form>
            </article>

            <div class="panel mt-3">
                <div class="panel-header">
                    <div>
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-chat-dots" aria-hidden="true"></i><span>Replies</span></h2>
                        <p class="text-muted mb-0">Review public replies and flag anything that needs a professional response.</p>
                    </div>
                </div>

                <div class="moderation-layout">
                    @forelse ($topic->replies as $reply)
                        <article class="moderation-item">
                            <div class="moderation-item__header">
                                <div class="moderation-item__meta moderation-item__title">
                                    <span>{{ $reply->anonymous_name }}</span>
                                    <span>{{ optional($reply->created_at)->format('M d, Y') }}</span>
                                    @if ($reply->is_professional_clarification)
                                        <span class="badge text-bg-info">Professional clarification</span>
                                    @endif
                                </div>
                                <div class="moderation-item__badges d-flex flex-wrap gap-2">
                                    @if ($reply->is_hidden)
                                        <span class="badge text-bg-danger">Hidden</span>
                                    @endif
                                    @if ($reply->moderation_status !== 'none')
                                        <span class="badge text-bg-warning">{{ str_replace('_', ' ', $reply->moderation_status) }}</span>
                                    @endif
                                </div>
                            </div>

                            <p class="moderation-body mb-0">{{ $reply->body }}</p>

                            <form method="post" action="{{ route('admin.forum.moderate-reply', [$topic, $reply]) }}" class="moderation-form-grid">
                                @csrf
                                @method('PATCH')
                                <div>
                                    <label class="form-label">Status</label>
                                    <select name="moderation_status" class="form-select">
                                        @foreach ($statusOptions as $value => $label)
                                            <option value="{{ $value }}" @selected($reply->moderation_status === $value)>{{ $label }}</option>
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
                                    <label class="form-label">Internal note</label>
                                    <textarea name="moderation_note" rows="3" class="form-control">{{ $reply->moderation_note }}</textarea>
                                </div>
                                <div class="wide moderation-action-row">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" name="is_hidden" id="reply-hidden-{{ $reply->id }}" @checked($reply->is_hidden)>
                                        <label class="form-check-label" for="reply-hidden-{{ $reply->id }}">Hide from public forum</label>
                                    </div>
                                    <button class="btn btn-primary" type="submit"><i class="bi bi-flag me-2" aria-hidden="true"></i>Save reply review</button>
                                </div>
                            </form>

                            <form method="post" action="{{ route('admin.forum.contact-reply-author', [$topic, $reply]) }}" class="moderation-contact mt-3">
                                @csrf
                                <label class="form-label">Contact reply author</label>
                                <div class="input-group">
                                    <input name="message" class="form-control" placeholder="{{ $reply->user_id ? 'Message sent as a private notification' : 'No linked account for this reply' }}" @disabled(! $reply->user_id)>
                                    <button class="btn btn-outline-secondary" type="submit" @disabled(! $reply->user_id) title="Contact user" aria-label="Contact user">
                                        <i class="bi bi-send" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </form>
                        </article>
                    @empty
                        <p class="text-muted mb-0">No replies yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <aside class="panel moderation-side-panel">
                <div class="panel-header">
                    <div>
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-person-vcard" aria-hidden="true"></i><span>Linked account</span></h2>
                        <p class="text-muted mb-0">Anonymous public identity is preserved. Internal staff can see whether an account exists.</p>
                    </div>
                </div>

                <dl class="row moderation-account-list mb-0">
                    <dt class="col-5">Alias</dt>
                    <dd class="col-7">{{ $topic->anonymous_name }}</dd>
                    <dt class="col-5">User</dt>
                    <dd class="col-7">{{ $topic->user?->name ?? 'Not linked' }}</dd>
                    <dt class="col-5">Email</dt>
                    <dd class="col-7">{{ $topic->user?->email ?? 'Not available' }}</dd>
                    <dt class="col-5">Last review</dt>
                    <dd class="col-7">{{ optional($topic->moderated_at)->diffForHumans() ?? 'Not reviewed' }}</dd>
                </dl>
            </aside>
        </div>
    </section>
@endsection
