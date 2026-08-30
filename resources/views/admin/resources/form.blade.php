@extends('layouts.admin')

@php
    $pageTitle = $resource->exists ? 'Edit resource' : 'New resource';
    $subtitle = 'Add a verified local service to the directory.';
@endphp

@section('page-actions')
    <a href="{{ route('admin.resources.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>
        Back to resources
    </a>
@endsection

@section('content')
    <section class="panel mx-auto" style="max-width: 1040px;">
        <div class="panel-header">
            <h2 class="h5 mb-1 section-title"><i class="bi bi-geo-alt" aria-hidden="true"></i><span>{{ $resource->exists ? 'Update resource details' : 'Create support listing' }}</span></h2>
            <p class="text-muted mb-0">Keep phone, email, and location fields current for staff and students.</p>
        </div>

        <form method="post" action="{{ $action }}" class="row g-3">
            @csrf
            @if ($method !== 'POST')
                @method($method)
            @endif
            <div class="col-12 col-md-8">
                <label class="form-label fw-semibold">Name</label>
                <input name="name" type="text" value="{{ old('name', $resource->name) }}" class="form-control" required>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label fw-semibold">Service type</label>
                <input name="service_type" type="text" value="{{ old('service_type', $resource->service_type) }}" class="form-control" required>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Location</label>
                <input name="location" type="text" value="{{ old('location', $resource->location) }}" class="form-control" required>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label fw-semibold">Phone</label>
                <input name="contact_phone" type="text" value="{{ old('contact_phone', $resource->contact_phone) }}" class="form-control">
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label fw-semibold">Email</label>
                <input name="contact_email" type="email" value="{{ old('contact_email', $resource->contact_email) }}" class="form-control">
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label fw-semibold">Website</label>
                <input name="website" type="url" value="{{ old('website', $resource->website) }}" class="form-control">
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" rows="6" class="form-control" required>{{ old('description', $resource->description) }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-check d-flex align-items-center gap-2 mb-0">
                    <input type="checkbox" name="is_verified" value="1" @checked(old('is_verified', $resource->is_verified)) class="form-check-input m-0">
                    <span class="fw-semibold">Verified listing</span>
                </label>
            </div>
            <div class="col-12 d-flex flex-wrap gap-2">
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-check2-circle me-1" aria-hidden="true"></i>
                    Save resource
                </button>
                <a href="{{ route('admin.resources.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </section>
@endsection
