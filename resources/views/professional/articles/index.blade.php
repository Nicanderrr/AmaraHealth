@extends('layouts.admin')

@php
    $pageTitle = 'Knowledge hub';
    $subtitle = 'Review your article submissions and draft new educational content.';
@endphp

@section('page-actions')
    <a href="{{ route('professional.articles.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1" aria-hidden="true"></i>
        New draft
    </a>
@endsection

@section('content')
    <section class="panel">
        <div class="panel-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-journal-text" aria-hidden="true"></i><span>Your articles</span></h2>
                <p class="text-muted mb-0">Draft new content for admin review or track the approval status of your submissions.</p>
            </div>
            <span class="badge rounded-pill text-bg-light border">{{ $articles->total() }} drafts</span>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Category</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($articles as $article)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $article->title }}</div>
                                <div class="text-muted small text-truncate" style="max-width: 440px;">{{ $article->summary }}</div>
                            </td>
                            <td>{{ $article->category }}</td>
                            <td><span class="badge text-bg-light border text-dark">{{ $article->status }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">No articles yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $articles->links() }}</div>
    </section>
@endsection
