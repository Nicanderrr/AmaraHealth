@extends('layouts.admin')

@php
    $pageTitle = 'Resources';
    $subtitle = 'Manage the verified support directory.';
@endphp

@section('page-actions')
    <a href="{{ route('admin.resources.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1" aria-hidden="true"></i>
        New resource
    </a>
@endsection

@section('content')
    <section class="panel">
        <div class="panel-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-folder2-open" aria-hidden="true"></i><span>Directory list</span></h2>
                <p class="text-muted mb-0">Use verified contacts and current location details.</p>
            </div>
            <span class="badge rounded-pill text-bg-light border">{{ $resources->total() }} total resources</span>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th scope="col">Service</th>
                        <th scope="col">Name</th>
                        <th scope="col">Contacts</th>
                        <th scope="col">Location</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($resources as $resource)
                        <tr>
                            <td>{{ $resource->service_type }}</td>
                            <td>
                                <div class="fw-semibold">{{ $resource->name }}</div>
                                <div class="text-muted small text-truncate" style="max-width: 360px;">{{ $resource->description }}</div>
                            </td>
                            <td class="small">
                                @if ($resource->contact_phone)
                                    <div>{{ $resource->contact_phone }}</div>
                                @endif
                                @if ($resource->contact_email)
                                    <div>{{ $resource->contact_email }}</div>
                                @endif
                                @if ($resource->website)
                                    <div class="text-truncate" style="max-width: 240px;">{{ $resource->website }}</div>
                                @endif
                            </td>
                            <td>{{ $resource->location }}</td>
                            <td>
                                <span class="badge {{ $resource->is_verified ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $resource->is_verified ? 'Verified' : 'Pending' }}</span>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm" role="group" aria-label="Resource actions">
                                    <a href="{{ route('admin.resources.edit', $resource) }}" class="btn btn-light">Edit</a>
                                    <form method="post" action="{{ route('admin.resources.destroy', $resource) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger" type="submit">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No resources found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $resources->links() }}</div>
    </section>
@endsection
