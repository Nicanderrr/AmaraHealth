@extends('layouts.admin')

@php
    $pageTitle = 'Professionals';
    $subtitle = 'Manage verified health professionals and their assigned categories.';
@endphp

@section('page-actions')
    <a href="{{ route('admin.professionals.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-person-plus me-1" aria-hidden="true"></i>
        New professional
    </a>
@endsection

@section('content')
    <section class="panel">
        <div class="panel-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-people" aria-hidden="true"></i><span>Health professionals</span></h2>
                <p class="text-muted mb-0">Create and review professional accounts from the admin workspace.</p>
            </div>
            <span class="badge rounded-pill text-bg-light border">{{ $professionals->total() }} professionals</span>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th scope="col">Professional</th>
                        <th scope="col">Title</th>
                        <th scope="col">Email</th>
                        <th scope="col">Categories</th>
                        <th scope="col">Availability</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($professionals as $professional)
                        <tr>
                            <td class="fw-semibold">{{ $professional->name }}</td>
                            <td>{{ $professional->professional_title }}</td>
                            <td class="text-muted">{{ $professional->university_email }}</td>
                            <td class="small">{{ implode(', ', $professional->assigned_categories ?? []) }}</td>
                            <td><span class="badge text-bg-success">{{ $professional->availability }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No professionals yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $professionals->links() }}</div>
    </section>
@endsection
