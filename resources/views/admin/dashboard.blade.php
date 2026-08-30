@extends('layouts.admin')

@php
    $pageTitle = 'Operations command center';
    $subtitle = 'Monitor content, support requests, and moderation activity from one workspace.';
    $latestConsultationRows = $latestConsultations->take(5);
    $latestTopicRows = $latestTopics->take(5);

    $trendLabels = collect($consultationTrendLabels ?? []);
    $trendValues = collect($consultationTrendValues ?? []);
    $trendMax = max(1, $trendValues->max() ?: 0);

    $statusPalette = [
        'submitted' => '#9F1239',
        'assigned' => '#E11D48',
        'under_review' => '#FB7185',
        'awaiting_student_response' => '#F43F5E',
        'response_ready' => '#BE123C',
        'closed' => '#5f0f2f',
        'unassigned' => '#FDA4AF',
    ];

    $statusTotal = max(1, (int) $consultationStatusCounts->sum());
    $pieSegments = [];
    $cursor = 0;

    foreach ($consultationStatusCounts as $status => $count) {
        $percent = $statusTotal > 0 ? ($count / $statusTotal) * 100 : 0;
        $pieSegments[] = [
            'label' => $consultationStatusLabels[$status] ?? $status,
            'count' => $count,
            'percent' => $percent,
            'start' => $cursor,
            'end' => $cursor + $percent,
            'color' => $statusPalette[$status] ?? '#94A3B8',
        ];
        $cursor += $percent;
    }
    $pieGradient = collect($pieSegments)->map(fn ($segment) => "{$segment['color']} {$segment['start']}% {$segment['end']}%")->implode(', ');
@endphp

@section('content')
    <style>
        .dashboard-chart-card {
            border: 1px solid var(--admin-border);
            border-radius: 8px;
            background: var(--admin-surface);
            box-shadow: var(--admin-shadow);
            padding: 1.35rem;
        }
        .consultation-status-card {
            max-height: 422px;
            overflow-y: auto;
            scrollbar-gutter: stable;
        }
        .consultation-status-card .panel-header {
            margin-bottom: 0.9rem;
        }
        .trend-chart {
            display: grid;
            gap: 1rem;
        }
        .trend-bars {
            min-height: 260px;
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
            align-items: end;
            gap: 0.8rem;
            padding: 1rem 0 0;
        }
        .trend-bar {
            display: grid;
            gap: 0.55rem;
            align-items: end;
            justify-items: center;
        }
        .trend-bar-track {
            width: 100%;
            min-height: 220px;
            display: flex;
            align-items: end;
            background: linear-gradient(180deg, #fff7fa 0%, #ffffff 100%);
            border: 1px solid var(--admin-border);
            border-radius: 8px;
            padding: 0.6rem;
        }
        .trend-bar-fill {
            width: 100%;
            height: var(--height);
            min-height: 12px;
            border-radius: 6px 6px 2px 2px;
            background: linear-gradient(180deg, #9F1239 0%, #B91C5C 100%);
            box-shadow: 0 10px 18px rgba(159, 18, 57, 0.18);
        }
        .trend-bar small {
            color: var(--admin-muted);
            font-weight: 700;
        }
        .pie-layout {
            display: grid;
            gap: 1.2rem;
            align-items: center;
        }
        .pie-chart-wrap {
            position: relative;
            width: min(170px, 100%);
            aspect-ratio: 1;
            margin: 0 auto;
            display: grid;
            place-items: center;
        }
        .pie-chart {
            position: absolute;
            inset: 0;
            border-radius: 50%;
            background: conic-gradient({{ $pieGradient }});
            box-shadow: inset 0 0 0 10px #fff;
        }
        .pie-chart::after {
            content: "";
            position: absolute;
            inset: 28%;
            border-radius: 50%;
            background: #fff;
            box-shadow: inset 0 0 0 1px var(--admin-border);
        }
        .pie-center {
            position: absolute;
            inset: 28%;
            display: grid;
            place-content: center;
            z-index: 1;
            text-align: center;
            pointer-events: none;
        }
        .pie-center strong {
            display: block;
            font-size: 1.65rem;
            line-height: 1;
        }
        .pie-legend {
            display: grid;
            gap: 0.7rem;
        }
        .legend-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            padding: 0.6rem 0.75rem;
            border: 1px solid var(--admin-border);
            border-radius: 8px;
            background: #fff;
        }
        .legend-key {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            min-width: 0;
        }
        .legend-swatch {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            flex: 0 0 auto;
        }
    </style>

    <section class="row g-3 mt-1" aria-label="Dashboard metrics">
        <div class="col-12 col-sm-6 col-xl-3">
            <article class="metric-card metric-primary">
                <div class="metric-top">
                    <span class="metric-label">Students</span>
                    <span class="metric-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">{{ $students }}</div>
                <div class="metric-meta">
                    <span class="text-success">Active students</span>
                    <span>registered on the platform</span>
                </div>
            </article>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <article class="metric-card metric-success">
                <div class="metric-top">
                    <span class="metric-label">Articles</span>
                    <span class="metric-icon"><i class="bi bi-journal-text" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">{{ $articles }}</div>
                <div class="metric-meta">
                    <span class="text-success">Published content</span>
                    <span>in the health library</span>
                </div>
            </article>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <article class="metric-card metric-warning">
                <div class="metric-top">
                    <span class="metric-label">Resources</span>
                    <span class="metric-icon"><i class="bi bi-folder2-open" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">{{ $resources }}</div>
                <div class="metric-meta">
                    <span class="text-success">Verified listings</span>
                    <span>in the directory</span>
                </div>
            </article>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <article class="metric-card metric-danger">
                <div class="metric-top">
                    <span class="metric-label">Consultations</span>
                    <span class="metric-icon"><i class="bi bi-heart-pulse" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">{{ $consultations }}</div>
                <div class="metric-meta">
                    <span class="text-danger">{{ $openConsultations }} open</span>
                    <span>intake requests</span>
                </div>
            </article>
        </div>
    </section>

    <section class="row g-3 mt-1">
        <div class="col-12 col-xl-8">
            <div class="dashboard-chart-card h-100">
                <div class="panel-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div>
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-graph-up-arrow" aria-hidden="true"></i><span>Consultation trend</span></h2>
                        <p class="text-muted mb-0">Requests created across the last 7 days.</p>
                    </div>
                    <span class="badge rounded-pill text-bg-light border">Last 7 days</span>
                </div>

                <div class="trend-chart">
                    <div class="trend-bars">
                        @foreach ($trendLabels as $index => $label)
                            @php
                                $value = (int) ($trendValues[$index] ?? 0);
                                $height = $trendMax > 0 ? max(8, round(($value / $trendMax) * 100)) : 8;
                            @endphp
                            <div class="trend-bar">
                                <div class="trend-bar-track">
                                    <div class="trend-bar-fill" style="--height: {{ $height }}%;"></div>
                                </div>
                                <small>{{ $label }}</small>
                                <span class="fw-semibold">{{ $value }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="dashboard-chart-card consultation-status-card">
                <div class="panel-header">
                    <div>
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-pie-chart" aria-hidden="true"></i><span>Consultation status</span></h2>
                        <p class="text-muted mb-0">Breakdown of current workflow state.</p>
                    </div>
                </div>

                <div class="pie-layout">
                    <div class="pie-chart-wrap">
                        <div class="pie-chart"></div>
                        <div class="pie-center">
                            <strong>{{ $consultations }}</strong>
                            <div class="text-muted small">Total cases</div>
                        </div>
                    </div>

                    <div class="pie-legend">
                        @foreach ($pieSegments as $segment)
                            <div class="legend-item">
                                <span class="legend-key">
                                    <span class="legend-swatch" style="background: {{ $segment['color'] }};"></span>
                                    <span>{{ $segment['label'] }}</span>
                                </span>
                                <span class="fw-semibold">{{ $segment['count'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="row g-3 mt-1">
        <div class="col-12 col-xl-8">
            <div class="panel h-100">
                <div class="panel-header">
                    <div>
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-heart-pulse" aria-hidden="true"></i><span>Consultation queue</span></h2>
                        <p class="text-muted mb-0">Latest support requests waiting for review.</p>
                    </div>
                    <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.consultations.index') }}">View all</a>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Tracking</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Concern</th>
                                <th scope="col">Professional</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-end">Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($latestConsultationRows as $consultation)
                                <tr>
                                    <td><span class="badge text-bg-secondary">{{ $consultation->tracking_code }}</span></td>
                                    <td class="fw-semibold">{{ $consultation->subject }}</td>
                                    <td>{{ $consultation->concern_type }}</td>
                                    <td>
                                        @if ($consultation->assignedProfessional)
                                            {{ $consultation->assignedProfessional->display_name ?: $consultation->assignedProfessional->name }}
                                        @else
                                            <span class="text-muted">Awaiting assignment</span>
                                        @endif
                                    </td>
                                    <td><span class="badge text-bg-warning">{{ $consultation->status }}</span></td>
                                    <td class="text-end text-muted small">{{ optional($consultation->created_at)->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-muted py-4">No consultation requests found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="panel h-100">
                <div class="panel-header">
                    <div>
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-chat-square-text" aria-hidden="true"></i><span>Forum activity</span></h2>
                        <p class="text-muted mb-0">Newest anonymous discussions in the workspace.</p>
                    </div>
                    <a class="btn btn-light btn-sm" href="{{ route('admin.forum.index') }}">Moderate</a>
                </div>

                <div class="activity-list">
                    @forelse ($latestTopicRows as $topic)
                        <div class="activity-item">
                            <span class="activity-dot bg-primary"></span>
                            <div>
                                <p class="mb-1 fw-semibold">{{ $topic->title }}</p>
                                <p class="text-muted small mb-0">{{ $topic->anonymous_name }} · {{ $topic->replies_count }} replies</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No forum topics found.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <section class="row g-3 mt-1">
        <div class="col-12 col-xl-8">
            <div class="panel">
                <div class="panel-header">
                    <div>
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i><span>Recent consultations</span></h2>
                        <p class="text-muted mb-0">Latest account activity across the workspace.</p>
                    </div>
                    <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.consultations.index') }}">Open queue</a>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Subject</th>
                                <th scope="col">Tracking</th>
                                <th scope="col">Professional</th>
                                <th scope="col">Status</th>
                                <th scope="col">Joined</th>
                                <th scope="col" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($latestConsultationRows as $consultation)
                                <tr>
                                    <td class="fw-semibold">{{ $consultation->subject }}</td>
                                    <td class="text-muted">{{ $consultation->tracking_code }}</td>
                                    <td>
                                        @if ($consultation->assignedProfessional)
                                            {{ $consultation->assignedProfessional->display_name ?: $consultation->assignedProfessional->name }}
                                        @else
                                            <span class="text-muted">Awaiting assignment</span>
                                        @endif
                                    </td>
                                    <td><span class="badge text-bg-success">{{ $consultation->status }}</span></td>
                                    <td class="text-muted small">{{ optional($consultation->created_at)->format('M d, Y') }}</td>
                                    <td class="text-end"><a class="btn btn-light btn-sm" href="{{ route('admin.consultations.show', $consultation) }}">View</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="panel h-100">
                <div class="panel-header">
                    <div>
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-ui-checks-grid" aria-hidden="true"></i><span>Quick actions</span></h2>
                        <p class="text-muted mb-0">Fast links to editorial and support work.</p>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <a class="btn btn-primary" href="{{ route('admin.articles.create') }}"><i class="bi bi-pencil-square me-2"></i>New article</a>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.resources.create') }}"><i class="bi bi-folder-plus me-2"></i>New resource</a>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.consultations.index') }}"><i class="bi bi-heart-pulse me-2"></i>Open queue</a>
                </div>
            </div>
        </div>
    </section>
@endsection
