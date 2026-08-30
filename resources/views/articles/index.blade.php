@extends('layouts.app')

@section('content')
@php
    $publishedCount = $articles->total();
    $pageCount = $articles->count();
    $leadArticle = $articles->first();
    $articleRows = $articles->skip(1);
@endphp

@include('partials.page-header', [
    'breadcrumbLabel' => 'Library',
    'eyebrow' => 'Read without pressure',
    'title' => 'Straight answers for private questions',
    'description' => 'Find reproductive health guidance that speaks plainly, respects your privacy, and helps you choose your next step with more confidence.',
    'actions' => [
        ['label' => 'Start consultation', 'href' => route('consultations.create')],
        ['label' => 'Open tracker', 'href' => route('tracker.index'), 'variant' => 'secondary'],
    ],
    'metrics' => [
        ['label' => 'Articles ready', 'value' => $publishedCount, 'note' => 'Reviewed and available to read'],
        ['label' => 'Showing now', 'value' => $pageCount, 'note' => 'Quick reads on this screen'],
        ['label' => 'Freshest update', 'value' => $latestPublished ? $latestPublished->format('M j') : 'Recent', 'note' => 'Most recent library addition'],
    ],
    'metricLayout' => 'carousel',
])

<section class="section-shell library-section">
    <div class="container">
        <div class="library-layout">
            <aside class="library-rail">
                <form method="get" action="{{ route('articles.index') }}" class="library-search">
                    <label for="library-search-input">Search the library</label>
                    <div class="library-search__field">
                        <i class="fas fa-search" aria-hidden="true"></i>
                        <input id="library-search-input" name="q" type="search" value="{{ $search }}" placeholder="Search topics, symptoms, choices">
                    </div>
                    @if ($activeCategory !== '')
                        <input type="hidden" name="category" value="{{ $activeCategory }}">
                    @endif
                </form>

                <div class="library-filter">
                    <div class="library-filter__heading">
                        <span>Topics</span>
                        <strong>{{ $categories->sum('total') }}</strong>
                    </div>
                    <a href="{{ route('articles.index', array_filter(['q' => $search])) }}" class="library-topic {{ $activeCategory === '' ? 'active' : '' }}">
                        <span>All guidance</span>
                        <strong>{{ $categories->sum('total') }}</strong>
                    </a>
                    @foreach ($categories as $category)
                        <a href="{{ route('articles.index', array_filter(['q' => $search, 'category' => $category->category])) }}" class="library-topic {{ $activeCategory === $category->category ? 'active' : '' }}">
                            <span>{{ $category->category }}</span>
                            <strong>{{ $category->total }}</strong>
                        </a>
                    @endforeach
                </div>

                <div class="library-help">
                    <span class="theme-pill">Not sure?</span>
                    <p>Use the consultation flow when reading raises something personal or urgent.</p>
                    <a href="{{ route('consultations.create') }}">Start a private request</a>
                </div>
            </aside>

            <div class="library-main">
                @if ($search !== '' || $activeCategory !== '')
                    <div class="library-results-note">
                        <span>
                            Showing {{ $publishedCount }} {{ \Illuminate\Support\Str::plural('result', $publishedCount) }}
                            @if ($search !== '') for "{{ $search }}" @endif
                            @if ($activeCategory !== '') in {{ $activeCategory }} @endif
                        </span>
                        <a href="{{ route('articles.index') }}">Clear</a>
                    </div>
                @endif

                @if ($leadArticle)
                    <article class="library-lead">
                        <div class="library-lead__content">
                            <div class="library-meta">
                                <span>{{ $leadArticle->category }}</span>
                                <span>{{ optional($leadArticle->published_at)->format('M j, Y') ?? 'Recently updated' }}</span>
                            </div>
                            <h2>{{ $leadArticle->title }}</h2>
                            <p>{{ \Illuminate\Support\Str::limit($leadArticle->summary, 190) }}</p>
                            <a href="{{ route('articles.show', $leadArticle) }}" class="library-link">
                                Read this guide <i class="fas fa-arrow-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </article>

                    <div class="library-list">
                        @foreach ($articleRows as $article)
                            <article class="library-row">
                                <div class="library-row__date">
                                    <strong>{{ optional($article->published_at)->format('d') ?? 'New' }}</strong>
                                    <span>{{ optional($article->published_at)->format('M') ?? 'Now' }}</span>
                                </div>
                                <div class="library-row__body">
                                    <div class="library-meta">
                                        <span>{{ $article->category }}</span>
                                        <span>Private reading</span>
                                    </div>
                                    <h3>{{ $article->title }}</h3>
                                    <p>{{ \Illuminate\Support\Str::limit($article->summary, 150) }}</p>
                                </div>
                                <a href="{{ route('articles.show', $article) }}" class="library-row__action" aria-label="Open {{ $article->title }}">
                                    <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                </a>
                            </article>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        {{ $articles->links() }}
                    </div>
                @else
                    <div class="library-empty">
                        <span class="theme-pill">No matches</span>
                        <h2>Nothing matched that search.</h2>
                        <p>Try a broader word, choose a different topic, or clear the filters to return to the full library.</p>
                        <a href="{{ route('articles.index') }}" class="thm-btn">
                            <span class="thm-btn-text">Show all articles</span>
                            <span class="thm-btn-icon-box"><i class="fas fa-arrow-right"></i></span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
