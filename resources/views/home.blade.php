@extends('layouts.app')

@section('content')
@php
    $homepageHeroImage = $heroImageUrl ?? asset('themes/helpest/assets/images/backgrounds/slider-1-1.jpg');
    $overlay = max(0, min(100, (int) ($heroOverlayOpacity ?? 72)));
    $overlayDark = number_format($overlay / 100, 2, '.', '');
    $overlayMid = number_format(max(0.12, ($overlay - 18) / 100), 2, '.', '');
    $overlaySoft = number_format(max(0.04, ($overlay - 40) / 100), 2, '.', '');
    $imageOpacity = number_format(max(0.22, 1 - ($overlay / 150)), 2, '.', '');
@endphp

<section
    class="landing-hero main-slider"
    style="--hero-image-opacity: {{ $imageOpacity }}; --hero-overlay-dark: {{ $overlayDark }}; --hero-overlay-mid: {{ $overlayMid }}; --hero-overlay-soft: {{ $overlaySoft }};"
>
    <div class="landing-hero__image" style="background-image: url('{{ $homepageHeroImage }}');" aria-hidden="true"></div>
    <div class="container">
        <div class="landing-hero__inner landing-hero__inner--solo">
            <div class="landing-hero__copy">
                <div class="main-slider__sub-title-box">
                    <div class="main-slider__sub-title-shape"></div>
                    <p class="main-slider__sub-title">Care guidance without exposure</p>
                    <div class="main-slider__sub-title-shape"></div>
                </div>
                <h1 class="landing-hero__title main-slider__title">Your body. <span>Your</span> next step.</h1>
                <p class="landing-hero__text">
                    Amara Health gives female tertiary students a private place to learn, track changes, ask sensitive questions, and prepare for care with more confidence.
                </p>
                <div class="landing-hero__actions">
                    <a href="{{ route('consultations.create') }}" class="thm-btn">
                        <span class="thm-btn-text">Start Consultation</span>
                        <span class="thm-btn-icon-box"><i class="fas fa-arrow-right"></i></span>
                    </a>
                    <a href="{{ route('articles.index') }}" class="thm-btn is-secondary">
                        <span class="thm-btn-text">Explore Library</span>
                        <span class="thm-btn-icon-box"><i class="fas fa-arrow-right"></i></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-shell">
    <div class="container">
        <div class="section-heading">
            <div>
                <span class="theme-pill">What the system does</span>
                <h2 class="section-heading__title mt-3">Three main paths, one private workflow</h2>
            </div>
            <p class="section-heading__text">
                The interface keeps the template’s bold rhythm, but the content is tuned for library browsing, symptom tracking, and anonymous support.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="feature-card">
                    <div class="feature-card__icon"><span class="icon-fund-raising"></span></div>
                    <h3 class="feature-card__title">Health Library</h3>
                    <p class="feature-card__text">Read clear guidance on cycles, contraception, STIs, and care preparation at your own pace.</p>
                    <a href="{{ route('articles.index') }}" class="feature-card__link">Open library <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="feature-card">
                    <div class="feature-card__icon"><span class="icon-helping-hand"></span></div>
                    <h3 class="feature-card__title">Cycle Tracker</h3>
                    <p class="feature-card__text">Record period dates, symptoms, and notes in a private timeline that stays with your account.</p>
                    <a href="{{ route('tracker.index') }}" class="feature-card__link">Track now <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="feature-card">
                    <div class="feature-card__icon"><span class="icon-donation"></span></div>
                    <h3 class="feature-card__title">Anonymous Support</h3>
                    <p class="feature-card__text">Ask sensitive questions, compare experiences, and keep your identity out of the conversation.</p>
                    <a href="{{ route('forum.index') }}" class="feature-card__link">Join forum <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-shell pt-0">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <div class="info-panel">
                    <span class="info-panel__eyebrow">Why it fits</span>
                    <h2 class="info-panel__title">Built to feel calm, structured, and mobile first.</h2>
                    <p class="info-panel__text">
                        The design leans on deep rose surfaces, soft blush accents, and clean cards so sensitive tasks feel organized instead of clinical.
                    </p>
                    <ul class="info-panel__list">
                        <li>
                            <div class="icon"><i class="fas fa-lock"></i></div>
                            <div>
                                <strong>Privacy first</strong>
                                <p>Users can read, track, and post without exposing identity in public views.</p>
                            </div>
                        </li>
                        <li>
                            <div class="icon"><i class="fas fa-mobile-alt"></i></div>
                            <div>
                                <strong>Phone friendly</strong>
                                <p>Cards, buttons, and panels remain readable on compact screens and fast to scan.</p>
                            </div>
                        </li>
                        <li>
                            <div class="icon"><i class="fas fa-clipboard-list"></i></div>
                            <div>
                                <strong>Action oriented</strong>
                                <p>Each page points users to a next step instead of leaving them at a dead end.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card-tile cols-2">
                    <div class="panel-card p-3 overflow-hidden">
                        <img src="{{ asset('themes/helpest/assets/images/resources/about-three-img-1.jpg') }}" alt="" class="w-100 rounded-4">
                    </div>
                    <div class="panel-card p-4 d-flex flex-column justify-content-between">
                        <div>
                            <span class="theme-pill">Private by design</span>
                            <h3 class="mt-3 mb-2">Rose and blush set the tone across the platform.</h3>
                            <p class="text-muted mb-0">
                                The palette now behaves like a focused product UI instead of a decorative site, which makes the content read more clearly.
                            </p>
                        </div>
                        <div class="mt-4">
                            <div class="d-flex flex-wrap gap-2">
                                <span class="theme-pill">Library</span>
                                <span class="theme-pill">Tracker</span>
                                <span class="theme-pill">Forum</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-card p-4 mt-4">
                    <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1">Need a structured consultation flow?</h3>
                            <p class="mb-0 text-muted">The wizard collects concerns step by step, then routes them to the right professional.</p>
                        </div>
                        <a href="{{ route('consultations.create') }}" class="thm-btn">
                            <span class="thm-btn-text">Start Request</span>
                            <span class="thm-btn-icon-box"><i class="fas fa-arrow-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-shell stats-band">
    <div class="container">
        <div class="section-heading">
            <div>
                <span class="theme-pill">Live overview</span>
                <h2 class="section-heading__title mt-3">The platform stays active with real demo content</h2>
            </div>
            <p class="section-heading__text">
                These counts and previews keep the home page useful instead of turning it into a static banner.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-3 col-6">
                <div class="stat-card h-100">
                    <strong>{{ $featuredArticles->count() }}</strong>
                    <span>Featured articles</span>
                    <p>Prioritized reading for the most common student questions.</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card h-100">
                    <strong>{{ $resourceCount }}</strong>
                    <span>Verified resources</span>
                    <p>Places and contacts linked to local support.</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card h-100">
                    <strong>{{ $consultationCount }}</strong>
                    <span>Consultations</span>
                    <p>Private requests stored in the workflow.</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card h-100">
                    <strong>{{ $latestTopics->count() }}</strong>
                    <span>Forum topics</span>
                    <p>Fresh student conversations on the front page.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-shell">
    <div class="container">
        <div class="section-heading">
            <div>
                <span class="theme-pill">Latest content</span>
                <h2 class="section-heading__title mt-3">Recent articles, resources, and forum activity</h2>
            </div>
            <p class="section-heading__text">
                The home page now surfaces the content people will actually use next.
            </p>
        </div>

        <div class="card-tile cols-3">
            @foreach ($latestArticles as $article)
                <article class="article-card">
                    <div class="article-card__meta">
                        <span class="theme-pill">{{ $article->category }}</span>
                        <span class="theme-pill">{{ optional($article->published_at)->format('M j') ?? 'Recent' }}</span>
                    </div>
                    <h3 class="article-card__title">{{ $article->title }}</h3>
                    <p class="article-card__text">{{ \Illuminate\Support\Str::limit($article->summary, 120) }}</p>
                    <div class="article-card__footer">
                        <small class="text-muted">Approved reading</small>
                        <a href="{{ route('articles.show', $article) }}" class="feature-card__link">Read more <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>
            @endforeach

            @foreach ($latestResources as $resource)
                <article class="article-card">
                    <div class="article-card__meta">
                        <span class="theme-pill">{{ $resource->service_type }}</span>
                        <span class="theme-pill">{{ $resource->is_verified ? 'Verified' : 'Pending' }}</span>
                    </div>
                    <h3 class="article-card__title">{{ $resource->name }}</h3>
                    <p class="article-card__text">{{ \Illuminate\Support\Str::limit($resource->description, 120) }}</p>
                    <div class="article-card__footer">
                        <small class="text-muted">{{ $resource->location }}</small>
                        <a href="{{ route('resources.index') }}" class="feature-card__link">Open resources <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>
            @endforeach

            @foreach ($latestTopics as $topic)
                <article class="forum-card">
                    <div class="forum-card__meta">
                        <span class="theme-pill">{{ $topic->anonymous_name }}</span>
                        <span class="theme-pill">{{ $topic->replies_count }} replies</span>
                    </div>
                    <h3 class="forum-card__title">{{ $topic->title }}</h3>
                    <p class="forum-card__text">{{ \Illuminate\Support\Str::limit($topic->body, 120) }}</p>
                    <div class="forum-card__footer">
                        <small class="text-muted">{{ $topic->last_reply_at ? $topic->last_reply_at->format('M j, Y') : 'No replies yet' }}</small>
                        <a href="{{ route('forum.show', $topic) }}" class="feature-card__link">Open topic <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="section-shell pt-0">
    <div class="container">
        <div class="cta-panel">
            <div class="row g-4 align-items-center position-relative" style="z-index: 1;">
                <div class="col-lg-8">
                    <span class="theme-pill">Next step</span>
                    <h2 class="section-heading__title mt-3">Need help preparing for a clinic visit?</h2>
                    <p class="section-heading__text mt-3 mb-0">
                        Use the consultation wizard to describe symptoms, choose a category, and route the request to the right professional without public exposure.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('consultations.create') }}" class="thm-btn">
                        <span class="thm-btn-text">Begin consultation</span>
                        <span class="thm-btn-icon-box"><i class="fas fa-arrow-right"></i></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
