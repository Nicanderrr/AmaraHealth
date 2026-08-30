@extends('layouts.admin')

@php
    $pageTitle = 'Articles';
    $subtitle = 'Create and manage the health education library.';
@endphp

@section('page-actions')
    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1" aria-hidden="true"></i>
        New article
    </a>
@endsection

@section('content')
    <section class="panel">
        <div class="panel-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-journal-text" aria-hidden="true"></i><span>Editorial queue</span></h2>
                <p class="text-muted mb-0">Keep the library current and aligned to the latest guidance.</p>
            </div>
            <span class="badge rounded-pill text-bg-light border">{{ $articles->total() }} total articles</span>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Category</th>
                        <th scope="col">Status</th>
                        <th scope="col">Published</th>
                        <th scope="col" class="text-end">Actions</th>
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
                            <td>
                                <span class="badge text-bg-light border text-dark">{{ $article->status }}</span>
                                @if ($article->is_featured)
                                    <span class="badge text-bg-warning ms-1">Featured</span>
                                @endif
                            </td>
                            <td class="text-muted">{{ optional($article->published_at)->format('M d, Y') ?? 'Unpublished' }}</td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm" role="group" aria-label="Article actions">
                                    <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-light">Edit</a>
                                    <form method="post" action="{{ route('admin.articles.destroy', $article) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger" type="submit">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No articles found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $articles->links() }}</div>
    </section>
@endsection
