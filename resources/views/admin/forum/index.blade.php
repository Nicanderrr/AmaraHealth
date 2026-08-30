@extends('layouts.admin')

@php
    $pageTitle = 'Forum moderation';
    $subtitle = 'Lock or remove anonymous posts when needed.';
@endphp

@section('page-actions')
    <span class="badge rounded-pill text-bg-light border">{{ $topics->total() }} topics</span>
@endsection

@section('content')
    <style>
        .forum-action-group {
            display: inline-flex;
            align-items: center;
            justify-content: flex-end;
            gap: 0.35rem;
            flex-wrap: nowrap;
        }
        .forum-action-group form {
            display: inline-flex;
            margin: 0;
        }
        .forum-action-group .btn {
            display: inline-grid;
            place-items: center;
            width: 34px;
            height: 34px;
            padding: 0;
        }
        .forum-topic-cell {
            min-width: 220px;
            max-width: 520px;
        }
        .forum-topic-cell .fw-semibold {
            overflow-wrap: anywhere;
        }
    </style>

    <section class="panel">
        <div class="panel-header">
            <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-chat-square-text" aria-hidden="true"></i><span>Forum queue</span></h2>
                <p class="text-muted mb-0">Review posts, lock problem threads, or remove content when necessary.</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th scope="col">Topic</th>
                        <th scope="col">Replies</th>
                        <th scope="col">Status</th>
                        <th scope="col">Created</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($topics as $topic)
                        <tr>
                            <td class="forum-topic-cell">
                                <div class="fw-semibold">{{ $topic->title }}</div>
                                <div class="text-muted small">{{ $topic->anonymous_name }}</div>
                            </td>
                            <td>{{ $topic->replies_count }}</td>
                            <td>
                                <span class="badge {{ $topic->is_locked ? 'text-bg-dark' : 'text-bg-success' }}">{{ $topic->is_locked ? 'Locked' : 'Open' }}</span>
                            </td>
                            <td class="text-muted">{{ optional($topic->created_at)->diffForHumans() }}</td>
                            <td class="text-end">
                                <div class="forum-action-group" role="group" aria-label="Forum actions">
                                    <a class="btn btn-light" href="{{ route('admin.forum.show', $topic) }}" aria-label="Open topic" title="Open topic">
                                        <i class="bi bi-eye" aria-hidden="true"></i>
                                    </a>
                                    <form method="post" action="{{ route('admin.forum.toggle', $topic) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button
                                            class="btn btn-light"
                                            type="submit"
                                            aria-label="{{ $topic->is_locked ? 'Unlock topic' : 'Lock topic' }}"
                                            title="{{ $topic->is_locked ? 'Unlock topic' : 'Lock topic' }}"
                                        >
                                            <i class="bi {{ $topic->is_locked ? 'bi-unlock' : 'bi-lock' }}" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                    <form method="post" action="{{ route('admin.forum.destroy', $topic) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger" type="submit" aria-label="Delete topic" title="Delete topic">
                                            <i class="bi bi-trash" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No forum topics found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $topics->links() }}</div>
    </section>
@endsection
