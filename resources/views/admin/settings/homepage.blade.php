@extends('layouts.admin')

@php
    $pageTitle = 'Site settings';
    $subtitle = 'Manage homepage presentation from the admin workspace.';
@endphp

@section('content')
    <section class="panel mx-auto" style="max-width: 1040px;">
        <div class="panel-header">
            <h2 class="h5 mb-1 section-title">
                <i class="bi bi-image" aria-hidden="true"></i>
                <span>Homepage hero image</span>
            </h2>
            <p class="text-muted mb-0">Upload JPG, PNG, or WebP images for the homepage and page hero sections.</p>
        </div>

        <div class="row g-4 align-items-start">
            <div class="col-lg-6">
                <form method="post" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="row g-3">
                    @csrf
                    @method('PUT')

                    <div class="col-12">
                        <label class="form-label fw-semibold">Hero image</label>
                        <input name="hero_image" type="file" accept="image/jpeg,image/png,image/webp" class="form-control">
                        <div class="form-text">Recommended: landscape image, at least 1600px wide, under 4MB.</div>
                    </div>

                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center gap-3">
                            <label for="hero-overlay-opacity" class="form-label fw-semibold mb-0">Overlay transparency</label>
                            <span class="badge text-bg-light border text-dark"><span data-overlay-value>{{ $heroOverlayOpacity }}</span>%</span>
                        </div>
                        <input
                            id="hero-overlay-opacity"
                            name="hero_overlay_opacity"
                            type="range"
                            min="0"
                            max="100"
                            step="1"
                            value="{{ old('hero_overlay_opacity', $heroOverlayOpacity) }}"
                            class="form-range"
                            oninput="document.querySelector('[data-overlay-value]').textContent = this.value"
                        >
                        <div class="form-text">Lower values show more of the homepage photo. Higher values make the rose overlay stronger.</div>
                    </div>

                    @if ($heroImagePath)
                        <div class="col-12">
                            <label class="form-check d-flex align-items-center gap-2 mb-0">
                                <input type="checkbox" name="remove_hero_image" value="1" class="form-check-input m-0">
                                <span class="fw-semibold">Remove current hero image</span>
                            </label>
                        </div>
                    @endif

                    <div class="col-12 d-flex flex-wrap gap-2">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-cloud-arrow-up me-1" aria-hidden="true"></i>
                            Save hero settings
                        </button>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-box-arrow-up-right me-1" aria-hidden="true"></i>
                            View homepage
                        </a>
                    </div>
                </form>
            </div>

            <div class="col-lg-6">
                <div class="border rounded-3 overflow-hidden bg-light">
                    @if ($heroImageUrl)
                        <img src="{{ $heroImageUrl }}" alt="Current homepage hero" class="w-100" style="aspect-ratio: 16 / 10; object-fit: cover;">
                    @else
                        <div class="d-flex align-items-center justify-content-center text-muted" style="aspect-ratio: 16 / 10;">
                            <div class="text-center">
                                <i class="bi bi-image fs-1 d-block mb-2" aria-hidden="true"></i>
                                No custom hero image yet.
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <hr class="my-4">

        <div class="panel-header px-0 pt-0">
            <h2 class="h5 mb-1 section-title">
                <i class="bi bi-images" aria-hidden="true"></i>
                <span>Other page hero images</span>
            </h2>
            <p class="text-muted mb-0">Set different hero background images for the major frontend sections.</p>
        </div>

        <form method="post" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="row g-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="hero_overlay_opacity" value="{{ old('hero_overlay_opacity', $heroOverlayOpacity) }}">

            @foreach ($pageHeroImages as $pageHero)
                <div class="col-md-6">
                    <div class="border rounded-3 p-3 h-100">
                        <label class="form-label fw-semibold">{{ $pageHero['label'] }}</label>
                        <input name="page_hero_images[{{ $pageHero['key'] }}]" type="file" accept="image/jpeg,image/png,image/webp" class="form-control">
                        @if ($pageHero['url'])
                            <img src="{{ $pageHero['url'] }}" alt="{{ $pageHero['label'] }} current hero" class="w-100 rounded-3 mt-3" style="aspect-ratio: 16 / 7; object-fit: cover;">
                            <label class="form-check d-flex align-items-center gap-2 mt-3 mb-0">
                                <input type="checkbox" name="remove_page_hero_images[{{ $pageHero['key'] }}]" value="1" class="form-check-input m-0">
                                <span>Remove current image</span>
                            </label>
                        @else
                            <div class="d-flex align-items-center justify-content-center text-muted rounded-3 bg-light mt-3" style="aspect-ratio: 16 / 7;">
                                No custom image yet.
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

            <div class="col-12 d-flex flex-wrap gap-2">
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-check2-circle me-1" aria-hidden="true"></i>
                    Save page hero images
                </button>
                <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-box-arrow-up-right me-1" aria-hidden="true"></i>
                    Preview library
                </a>
            </div>
        </form>
    </section>
@endsection
