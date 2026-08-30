@extends('layouts.admin')

@php
    $pageTitle = $article->exists ? 'Edit draft' : 'New draft';
    $subtitle = 'Write an article for admin approval.';
@endphp

@section('page-actions')
    <a href="{{ route('professional.articles.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>
        Back to drafts
    </a>
@endsection

@section('content')
    <section class="panel mx-auto" style="max-width: 1040px;">
        <div class="panel-header">
            <h2 class="h5 mb-1 section-title"><i class="bi bi-pencil-square" aria-hidden="true"></i><span>{{ $article->exists ? 'Edit draft' : 'Create draft' }}</span></h2>
            <p class="text-muted mb-0">Submitted articles go to the admin approval queue.</p>
        </div>

        <form method="post" action="{{ $action }}" class="row g-3">
            @csrf
            @if ($method !== 'POST')
                @method($method)
            @endif
            <input type="hidden" name="status" value="pending_approval">
            <div class="col-12">
                <label class="form-label fw-semibold">Title</label>
                <input name="title" type="text" class="form-control" value="{{ old('title', $article->title) }}" required>
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label fw-semibold">Category</label>
                <input name="category" type="text" class="form-control" value="{{ old('category', $article->category) }}" required>
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label fw-semibold">Summary</label>
                <input name="summary" type="text" class="form-control" value="{{ old('summary', $article->summary) }}" required>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Content</label>
                <textarea name="content" rows="12" class="form-control" required>{{ old('content', $article->content) }}</textarea>
            </div>
            <div class="col-12 d-flex flex-wrap gap-2">
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-send me-1" aria-hidden="true"></i>
                    Submit for approval
                </button>
            </div>
        </form>
    </section>
@endsection
