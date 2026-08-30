@extends('layouts.admin')

@php
    $pageTitle = 'Professional workspace';
    $subtitle = 'Review assigned consultations, respond to students, and track your article drafts.';
@endphp

@section('content')
    <section class="row g-3 mt-1" aria-label="Workspace metrics">
        <div class="col-12 col-sm-6 col-xl-4">
            <article class="metric-card metric-primary">
                <div class="metric-top">
                    <span class="metric-label">Cases</span>
                    <span class="metric-icon"><i class="bi bi-heart-pulse" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">{{ $caseCount }}</div>
                <div class="metric-meta">
                    <span class="text-success">{{ $openCount }} open</span>
                    <span>assigned consultations</span>
                </div>
            </article>
        </div>

        <div class="col-12 col-sm-6 col-xl-4">
            <article class="metric-card metric-success">
                <div class="metric-top">
                    <span class="metric-label">Drafts</span>
                    <span class="metric-icon"><i class="bi bi-journal-text" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">{{ $draftArticles->count() }}</div>
                <div class="metric-meta">
                    <span class="text-success">Knowledge hub</span>
                    <span>article submissions</span>
                </div>
            </article>
        </div>

        <div class="col-12 col-sm-6 col-xl-4">
            <article class="metric-card metric-warning">
                <div class="metric-top">
                    <span class="metric-label">Alerts</span>
                    <span class="metric-icon"><i class="bi bi-bell" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">{{ $notifications->count() }}</div>
                <div class="metric-meta">
                    <span class="text-success">Inbox items</span>
                    <span>need attention</span>
                </div>
            </article>
        </div>
    </section>

    <section class="row g-3 mt-1">
        <div class="col-12 col-xl-7">
            <div class="panel h-100">
                <div class="panel-header">
                    <div>
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-heart-pulse" aria-hidden="true"></i><span>Consultation queue</span></h2>
                        <p class="text-muted mb-0">Open each case, review the intake, and submit your recommendation.</p>
                    </div>
                    <a class="btn btn-outline-secondary btn-sm" href="{{ route('professional.consultations.index') }}">View all</a>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Tracking</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Concern</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-end">Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($assignedConsultations as $consultation)
                                <tr>
                                    <td><span class="badge text-bg-secondary">{{ $consultation->tracking_code }}</span></td>
                                    <td class="fw-semibold">{{ $consultation->subject }}</td>
                                    <td>{{ $consultation->concern_category }}</td>
                                    <td><span class="badge text-bg-warning">{{ $consultation->status }}</span></td>
                                    <td class="text-end text-muted small">{{ optional($consultation->assigned_at ?? $consultation->created_at)->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-muted py-4">No assigned consultations yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-5">
            <div class="panel h-100">
                <div class="panel-header">
                    <div>
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-bell" aria-hidden="true"></i><span>Recent alerts</span></h2>
                        <p class="text-muted mb-0">See what needs attention right now.</p>
                    </div>
                </div>

                <div class="activity-list">
                    @forelse ($notifications as $notification)
                        <div class="activity-item">
                            <span class="activity-dot bg-primary"></span>
                            <div>
                                <p class="mb-1 fw-semibold">{{ $notification->type }}</p>
                                <p class="text-muted small mb-0">{{ $notification->displayMessage() }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No notifications yet.</p>
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
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-journal-text" aria-hidden="true"></i><span>Article drafts</span></h2>
                        <p class="text-muted mb-0">Your submitted articles waiting for approval or already published.</p>
                    </div>
                    <a href="{{ route('professional.articles.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-2"></i>New draft</a>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Status</th>
                                <th scope="col">Summary</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($draftArticles as $article)
                                <tr>
                                    <td class="fw-semibold">{{ $article->title }}</td>
                                    <td><span class="badge text-bg-secondary">{{ $article->status }}</span></td>
                                    <td class="text-muted small">{{ \Illuminate\Support\Str::limit($article->summary, 120) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-muted py-4">No article drafts yet.</td>
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
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-ui-checks-grid" aria-hidden="true"></i><span>Quick actions</span></h2>
                        <p class="text-muted mb-0">Fast links to your most common work.</p>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <a href="{{ route('professional.consultations.index') }}" class="btn btn-primary"><i class="bi bi-heart-pulse me-2"></i>Open queue</a>
                    <a href="{{ route('professional.articles.create') }}" class="btn btn-outline-secondary"><i class="bi bi-pencil-square me-2"></i>Draft article</a>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary"><i class="bi bi-house me-2"></i>View site</a>
                </div>
            </div>
        </div>
    </section>
@endsection
