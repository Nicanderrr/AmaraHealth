@extends('layouts.app')

@section('content')
@include('partials.page-header', [
    'eyebrow' => 'Start privately',
    'title' => 'Create a space for questions you do not want public',
    'description' => 'Use your Student ID to keep cycle records, send private concerns, and join anonymous discussions under one protected account.',
])

<section class="container pb-5">
    <div class="row g-4 align-items-stretch">
        <div class="col-lg-5">
            <div class="panel-card h-100 p-4 p-lg-5">
                <p class="theme-pill">What you get</p>
                <ul class="mt-4 mb-0">
                    <li>Private cycle tracker.</li>
                    <li>Consultation requests with tracking codes.</li>
                    <li>Anonymous forum participation.</li>
                </ul>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="panel-card p-4 p-lg-5">
                <form method="post" action="{{ route('register.store') }}" class="stack-grid">
                    @csrf
                    <div>
                        <label class="form-label">Display name</label>
                        <input name="display_name" type="text" value="{{ old('display_name') }}" class="form-control theme-input" required>
                    </div>
                    <div>
                        <label class="form-label">Student ID</label>
                        <input name="student_id" type="text" value="{{ old('student_id') }}" class="form-control theme-input" inputmode="numeric" maxlength="8" placeholder="8 digits" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Password</label>
                            <input name="password" type="password" class="form-control theme-input" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirm password</label>
                            <input name="password_confirmation" type="password" class="form-control theme-input" required>
                        </div>
                    </div>
                    <button class="thm-btn">
                        <span class="thm-btn-text">Create account</span>
                        <span class="thm-btn-icon-box"><i class="fas fa-arrow-right"></i></span>
                    </button>
                </form>
                <p class="mt-4 mb-0">Already registered? <a href="{{ route('login') }}">Log in</a></p>
            </div>
        </div>
    </div>
</section>
@endsection
