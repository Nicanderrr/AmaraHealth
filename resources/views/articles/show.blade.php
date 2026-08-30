@extends('layouts.app')

@section('content')
@php
    $readingTime = max(1, (int) ceil(str_word_count(strip_tags($article->content)) / 220));
    $paragraphs = collect(preg_split('/\R{2,}/', trim($article->content)))
        ->map(fn ($paragraph) => trim($paragraph))
        ->filter();
@endphp

@include('partials.page-header', [
    'eyebrow' => $article->category,
    'title' => $article->title,
    'description' => $article->summary,
    'actions' => [
        ['label' => 'Back to library', 'href' => route('articles.index')],
        ['label' => 'Start consultation', 'href' => route('consultations.create'), 'variant' => 'secondary'],
    ],
])

<section class="section-shell article-reader-section">
    <div class="container">
        <div class="article-reader-layout">
            <article class="article-reader">
                <div class="article-reader__meta">
                    <span>{{ $article->category }}</span>
                    <span>{{ optional($article->published_at)->format('j M Y') ?? 'Recently updated' }}</span>
                    <span>{{ $readingTime }} min read</span>
                </div>

                <div class="article-reader__intro">
                    <p>{{ $article->summary }}</p>
                </div>

                <div class="article-reader__body">
                    @forelse ($paragraphs as $paragraph)
                        <p>{!! nl2br(e($paragraph)) !!}</p>
                    @empty
                        <p>{{ $article->content }}</p>
                    @endforelse
                </div>
            </article>

            <aside class="article-reader-rail" aria-label="Article actions">
                <div class="article-reader-rail__block">
                    <span>Reading note</span>
                    <p>Use this guide for orientation. If something feels urgent, move from reading into a private consultation.</p>
                </div>

                <nav class="article-reader-actions">
                    <a href="{{ route('consultations.create') }}">
                        <span>Start a private consultation</span>
                        <i class="fas fa-arrow-right" aria-hidden="true"></i>
                    </a>
                    <a href="{{ route('forum.index') }}">
                        <span>Ask anonymously</span>
                        <i class="fas fa-arrow-right" aria-hidden="true"></i>
                    </a>
                    <a href="{{ route('tracker.index') }}">
                        <span>Open cycle tracker</span>
                        <i class="fas fa-arrow-right" aria-hidden="true"></i>
                    </a>
                    <a href="{{ route('articles.index') }}">
                        <span>Return to library</span>
                        <i class="fas fa-arrow-right" aria-hidden="true"></i>
                    </a>
                </nav>

                <div class="article-reader-rail__block article-reader-rail__block--quiet">
                    <span>Privacy reminder</span>
                    <p>Your account tools are separate from the public forum identity you choose.</p>
                </div>
            </aside>
        </div>
    </div>
</section>

<section class="article-next-section">
    <div class="container">
        <div class="article-next">
            <div>
                <span>Need more than reading?</span>
                <h2>Turn this into a care step when you are ready.</h2>
            </div>
            <div class="article-next__actions">
                <a href="{{ route('consultations.create') }}" class="thm-btn">
                    <span class="thm-btn-text">Start consultation</span>
                    <span class="thm-btn-icon-box"><i class="fas fa-arrow-right"></i></span>
                </a>
                <a href="{{ route('articles.index') }}" class="thm-btn is-secondary">
                    <span class="thm-btn-text">Back to library</span>
                    <span class="thm-btn-icon-box"><i class="fas fa-arrow-right"></i></span>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
