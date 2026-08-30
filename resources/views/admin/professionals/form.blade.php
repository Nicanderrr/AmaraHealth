@extends('layouts.admin')

@php
    $pageTitle = 'New professional';
    $subtitle = 'Create a health professional account and assign categories.';
@endphp

@section('page-actions')
    <a href="{{ route('admin.professionals.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>
        Back to professionals
    </a>
@endsection

@section('content')
    <section class="panel mx-auto" style="max-width: 1040px;">
        <div class="panel-header">
            <h2 class="h5 mb-1 section-title"><i class="bi bi-person-plus" aria-hidden="true"></i><span>Create professional account</span></h2>
            <p class="text-muted mb-0">The system will generate a temporary password after creation.</p>
        </div>

        <form method="post" action="{{ route('admin.professionals.store') }}" class="row g-3">
            @csrf
            <div class="col-12">
                <label class="form-label fw-semibold">Full name</label>
                <input name="name" type="text" class="form-control" required>
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label fw-semibold">Professional title</label>
                <select name="professional_title" class="form-select" required>
                    <option value="Doctor">Doctor</option>
                    <option value="Nurse">Nurse</option>
                    <option value="Counsellor">Counsellor</option>
                    <option value="Psychologist">Psychologist</option>
                    <option value="Sexual Health Educator">Sexual Health Educator</option>
                </select>
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label fw-semibold">University email</label>
                <input name="university_email" type="email" class="form-control" required>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Assigned categories</label>
                <div class="row g-2">
                    @foreach (['Menstrual Health', 'STIs & Sexual Health', 'Contraception', 'Pregnancy Concerns', 'General Reproductive Health'] as $category)
                        <div class="col-12 col-md-6">
                            <label class="border rounded-3 p-3 d-flex align-items-start gap-2 h-100">
                                <input type="checkbox" name="assigned_categories[]" value="{{ $category }}" class="form-check-input mt-1">
                                <span>{{ $category }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-12 d-flex flex-wrap gap-2">
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-check2-circle me-1" aria-hidden="true"></i>
                    Create professional
                </button>
            </div>
        </form>
    </section>
@endsection
