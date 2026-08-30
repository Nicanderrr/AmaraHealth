@extends('layouts.app')

@section('content')
@include('partials.page-header', [
    'eyebrow' => 'Welcome back',
    'title' => 'Step back into your private care space',
    'description' => 'Continue from your saved cycle notes, consultation requests, and anonymous conversations without starting over.',
])

<section class="container pb-5">
    <div class="row g-4 align-items-stretch">
        <div class="col-lg-5">
            <div class="panel-card h-100 p-4 p-lg-5">
                <p class="theme-pill">Private access</p>
                <h3 class="mt-4">Why log in?</h3>
                <ul class="mt-3 mb-0">
                    <li>Track cycle records privately.</li>
                    <li>Follow consultation responses.</li>
                    <li>Post and reply anonymously.</li>
                </ul>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="panel-card p-4 p-lg-5">
                <form method="post" action="{{ route('login.store') }}" class="stack-grid">
                    @csrf
                    <div>
                        <label class="form-label">Student ID or email</label>
                        <input name="identifier" type="text" value="{{ old('identifier') }}" class="form-control theme-input" autocomplete="username" required>
                    </div>
                    <div>
                        <label class="form-label">Password</label>
                        <input name="password" type="password" class="form-control theme-input" autocomplete="current-password" required>
                    </div>
                    <label class="d-flex align-items-center gap-2">
                        <input type="checkbox" name="remember" class="form-check-input m-0">
                        <span>Remember me</span>
                    </label>
                    <button class="thm-btn">
                        <span class="thm-btn-text">Log in</span>
                        <span class="thm-btn-icon-box"><i class="fas fa-arrow-right"></i></span>
                    </button>
                </form>
                <p class="mt-4 mb-0">New here? <a href="{{ route('register') }}">Create an account</a></p>
            </div>
        </div>
    </div>
</section>
@endsection
