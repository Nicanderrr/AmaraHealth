@php
    $metricLayout = $metricLayout ?? 'stack';
    $isMetricCarousel = $metricLayout === 'carousel';
    $headerBackground = $background ?? $configuredHeroBackground ?? asset('themes/helpest/assets/images/backgrounds/page-header-bg.jpg');
@endphp

<section class="page-header {{ $isMetricCarousel ? 'page-header--metric-carousel' : '' }}">
    <div class="page-header__bg" style="background-image: url({{ $headerBackground }});"></div>
    <div class="container">
        <div class="page-header__inner">
            <div class="page-header__copy">
                <span class="theme-pill page-header__eyebrow">{{ $eyebrow ?? 'Amara Health' }}</span>
                <h2>{{ $title }}</h2>
                @if (! empty($description))
                    <p>{{ $description }}</p>
                @endif
                @if (! empty($actions))
                    <div class="mt-4 d-flex flex-wrap gap-3">
                        @foreach ($actions as $action)
                            <a href="{{ $action['href'] }}" class="thm-btn {{ ($action['variant'] ?? 'primary') === 'secondary' ? 'is-secondary' : '' }}">
                                <span class="thm-btn-text">{{ $action['label'] }}</span>
                                <span class="thm-btn-icon-box"><i class="fas fa-arrow-right"></i></span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
            @if (! empty($metrics))
                @if ($isMetricCarousel)
                    <div class="page-header__metrics-carousel" aria-label="Library overview">
                        <div class="page-header__metrics page-header__metrics-track">
                            @foreach ($metrics as $metric)
                                <div class="page-header__metric">
                                    <span>{{ $metric['label'] }}</span>
                                    <strong>{{ $metric['value'] }}</strong>
                                    @if (! empty($metric['note']))
                                        <p>{{ $metric['note'] }}</p>
                                    @endif
                                </div>
                            @endforeach
                            @foreach ($metrics as $metric)
                                <div class="page-header__metric" aria-hidden="true">
                                    <span>{{ $metric['label'] }}</span>
                                    <strong>{{ $metric['value'] }}</strong>
                                    @if (! empty($metric['note']))
                                        <p>{{ $metric['note'] }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="page-header__metrics">
                        @foreach ($metrics as $metric)
                            <div class="page-header__metric">
                                <span>{{ $metric['label'] }}</span>
                                <strong>{{ $metric['value'] }}</strong>
                                @if (! empty($metric['note']))
                                    <p>{{ $metric['note'] }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif
        </div>
    </div>
</section>
