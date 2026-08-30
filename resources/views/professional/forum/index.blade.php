@extends('layouts.admin')

@php
    $pageTitle = 'Forum review';
    $subtitle = 'Review flagged discussions and add professional clarification where needed.';
@endphp

@section('page-actions')
    <span class="badge rounded-pill text-bg-light border">{{ $topics->total() }} flagged topics</span>
@endsection

@section('content')
    <style>
        .forum-topic-cell {
            min-width: 220px;
            max-width: 520px;
        }
        .forum-topic-cell .fw-semibold,
        .forum-review-reason {
            overflow-wrap: anywhere;
        }
        .forum-icon-action {
            display: inline-grid;
            place-items: center;
            width: 34px;
            height: 34px;
            padding: 0;
        }
    </style>

    <section class="panel">
        <div class="panel-header">
            <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-chat-square-heart" aria-hidden="true"></i><span>Flagged forum queue</span></h2>
                <p class="text-muted mb-0">Open a discussion, review the concern, and post a clarification when the public thread needs it.</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th scope="col">Topic</th>
                        <th scope="col">Replies</th>
                        <th scope="col">Review status</th>
                        <th scope="col">Reason</th>
                        <th scope="col" class="text-end">Action</th>
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
                            <td><span class="badge text-bg-warning">{{ str_replace('_', ' ', $topic->moderation_status) }}</span></td>
                            <td class="text-muted forum-review-reason">{{ str_replace('_', ' ', $topic->moderation_reason ?: 'Needs review') }}</td>
                            <td class="text-end">
                                <a class="btn btn-light btn-sm forum-icon-action" href="{{ route('professional.forum.show', $topic) }}" aria-label="Open topic" title="Open topic">
                                    <i class="bi bi-eye" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No flagged forum discussions need review.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $topics->links() }}</div>
    </section>
@endsection
