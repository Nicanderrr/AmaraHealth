@extends('layouts.app')

@section('content')
@include('partials.page-header', [
    'eyebrow' => 'Private intake',
    'title' => 'Tell the system what is worrying you',
    'description' => 'Choose the concern that fits best, share the details at your pace, and send it to the right care professional.',
])

<section class="container pb-5">
    <div class="panel-card p-4 p-lg-5">
        @if (! $selectedCategory)
            <div class="mb-4">
                <p class="theme-pill">Step 1</p>
                <h3 class="mt-3">Select a concern category</h3>
                <p class="text-muted mb-0">Pick the category that best matches your concern. You can only submit one category per consultation.</p>
            </div>

            <div class="row g-3">
                @foreach ($categories as $category)
                    <div class="col-md-6 col-xl-4">
                        <a href="{{ route('consultations.create', ['category' => $category, 'step' => 1]) }}" class="text-decoration-none text-reset">
                            <div class="border rounded-4 p-4 h-100">
                                <h4 class="mb-2">{{ $category }}</h4>
                                <p class="text-muted mb-0">Start a guided intake for this concern category.</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @elseif ($isReviewStep)
            <div class="mb-4">
                <p class="theme-pill">Review</p>
                <h3 class="mt-3">{{ $selectedCategory }}</h3>
                <p class="text-muted mb-0">Review your answers before submitting your consultation.</p>
            </div>

            <div class="stack-grid mb-4">
                @foreach (($answers ?? []) as $key => $value)
                    <div class="border rounded-4 p-3">
                        <strong>{{ str_replace('_', ' ', \Illuminate\Support\Str::headline($key)) }}</strong>
                        <div class="text-muted mt-1">
                            {{ is_array($value) ? implode(', ', $value) : $value }}
                        </div>
                    </div>
                @endforeach
            </div>

            <form method="post" action="{{ route('consultations.store') }}" class="d-flex flex-wrap gap-2">
                @csrf
                <input type="hidden" name="category" value="{{ $selectedCategory }}">
                <input type="hidden" name="finalize" value="1">
                <button class="thm-btn" type="submit">
                    <span class="thm-btn-text">Submit consultation</span>
                    <span class="thm-btn-icon-box"><i class="fas fa-arrow-right"></i></span>
                </button>
                <a href="{{ route('consultations.create', ['category' => $selectedCategory, 'step' => max(1, count($questions))]) }}" class="thm-btn thm-btn--sm is-secondary">
                    <span class="thm-btn-text">Back</span>
                </a>
            </form>
        @else
            @php
                $question = $questions[$currentStep - 1] ?? null;
            @endphp

            @if ($question)
                <div class="mb-4">
                    <p class="theme-pill">Step {{ $currentStep }} of {{ count($questions) }}</p>
                    <h3 class="mt-3">{{ $selectedCategory }}</h3>
                    <p class="text-muted mb-0">{{ $question['label'] }}</p>
                </div>

                <form method="post" action="{{ route('consultations.store') }}" class="stack-grid">
                    @csrf
                    <input type="hidden" name="category" value="{{ $selectedCategory }}">
                    <input type="hidden" name="step" value="{{ $currentStep }}">

                    @if ($question['type'] === 'single' || $question['type'] === 'duration')
                        <div class="stack-grid">
                            @foreach ($question['options'] as $option)
                                <label class="border rounded-4 p-3 d-flex align-items-center gap-3">
                                    <input type="radio" name="answer" value="{{ $option }}" class="form-check-input m-0" required>
                                    <span>{{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                    @elseif ($question['type'] === 'multi')
                        <div class="stack-grid">
                            @foreach ($question['options'] as $option)
                                <label class="border rounded-4 p-3 d-flex align-items-center gap-3">
                                    <input type="checkbox" name="answer[]" value="{{ $option }}" class="form-check-input m-0">
                                    <span>{{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                    @elseif ($question['type'] === 'scale')
                        <div>
                            <label class="form-label fw-bold">Select a value from 1 to 5</label>
                            <input type="range" min="1" max="5" step="1" name="answer" class="form-range" required>
                        </div>
                    @else
                        <textarea name="answer" rows="4" class="form-control theme-input" maxlength="{{ $question['max'] ?? 200 }}" required></textarea>
                    @endif

                    <div class="d-flex flex-wrap gap-2">
                        <button class="thm-btn" type="submit">
                            <span class="thm-btn-text">{{ $currentStep >= count($questions) ? 'Review answers' : 'Next question' }}</span>
                            <span class="thm-btn-icon-box"><i class="fas fa-arrow-right"></i></span>
                        </button>
                        <a href="{{ route('consultations.create') }}" class="thm-btn thm-btn--sm is-secondary">
                            <span class="thm-btn-text">Start over</span>
                        </a>
                    </div>
                </form>
            @endif
        @endif
    </div>
</section>
@endsection
