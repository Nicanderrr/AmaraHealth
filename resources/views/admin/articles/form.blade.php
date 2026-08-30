@extends('layouts.admin')

@php
    $pageTitle = $article->exists ? 'Edit article' : 'New article';
    $subtitle = 'Write education content for the private health library.';
@endphp

@section('page-actions')
    <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>
        Back to articles
    </a>
@endsection

@section('content')
    <section class="panel mx-auto" style="max-width: 1040px;">
        <div class="panel-header">
            <h2 class="h5 mb-1 section-title"><i class="bi bi-pencil-square" aria-hidden="true"></i><span>{{ $article->exists ? 'Update article details' : 'Create article record' }}</span></h2>
            <p class="text-muted mb-0">Use concise summaries and structured content so the library stays easy to scan.</p>
        </div>

        <form method="post" action="{{ $action }}" class="row g-3">
            @csrf
            @if ($method !== 'POST')
                @method($method)
            @endif
            <div class="col-12 col-md-8">
                <label class="form-label fw-semibold">Title</label>
                <input name="title" type="text" value="{{ old('title', $article->title) }}" class="form-control" required>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label fw-semibold">Category</label>
                <input name="category" type="text" value="{{ old('category', $article->category) }}" class="form-control" required>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label fw-semibold">Published at</label>
                <input name="published_at" type="datetime-local" value="{{ old('published_at', optional($article->published_at)->format('Y-m-d\TH:i')) }}" class="form-control">
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Summary</label>
                <textarea name="summary" rows="3" class="form-control" required>{{ old('summary', $article->summary) }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Content</label>
                <textarea name="content" rows="12" class="form-control" required>{{ old('content', $article->content) }}</textarea>
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select" required>
                    <option value="draft" @selected(old('status', $article->status ?? 'approved') === 'draft')>Draft</option>
                    <option value="pending_approval" @selected(old('status', $article->status ?? 'approved') === 'pending_approval')>Pending approval</option>
                    <option value="approved" @selected(old('status', $article->status ?? 'approved') === 'approved')>Approved</option>
                    <option value="rejected" @selected(old('status', $article->status ?? 'approved') === 'rejected')>Rejected</option>
                </select>
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label fw-semibold">Rejection reason</label>
                <textarea name="rejection_reason" rows="3" class="form-control">{{ old('rejection_reason', $article->rejection_reason) }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-check d-flex align-items-center gap-2 mb-0">
                    <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $article->is_featured)) class="form-check-input m-0">
                    <span class="fw-semibold">Feature on home page</span>
                </label>
            </div>
            <div class="col-12 d-flex flex-wrap gap-2">
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-check2-circle me-1" aria-hidden="true"></i>
                    Save article
                </button>
                <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </section>
@endsection
