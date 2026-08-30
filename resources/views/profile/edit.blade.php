@extends(auth()->user()?->isStudent() ? 'layouts.app' : 'layouts.admin')

@php
    $usesAdminLayout = ! auth()->user()?->isStudent();
    $pageTitle = 'Profile settings';
    $subtitle = 'Update your account identity and password.';
@endphp

@section('content')
    @unless ($usesAdminLayout)
        @include('partials.page-header', [
            'eyebrow' => 'Profile settings',
            'title' => 'Keep your account details current',
            'description' => 'Update the name, email address, and password connected to your private workspace.',
        ])
    @endunless

    <section class="{{ $usesAdminLayout ? '' : 'container pb-5' }}">
        <div class="row g-4 align-items-start">
            <div class="col-lg-7">
                <div class="{{ $usesAdminLayout ? 'panel' : 'panel-card' }} p-4 p-lg-5">
                    <div class="mb-4">
                        <span class="theme-pill">Account details</span>
                        <h2 class="h4 mt-3 mb-1">Name and email</h2>
                        <p class="text-muted mb-0">This is the identity used across your workspace and notifications.</p>
                    </div>

                    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="row g-3">
                        @csrf
                        @method('PUT')

                        <div class="col-12">
                            @php
                                $profilePhotoUrl = $user->profile_photo_path
                                    ? asset('storage/'.$user->profile_photo_path)
                                    : asset('themes/adminhmd/assets/images/avatar/avatar-fallback.jpg');
                            @endphp
                            <div class="d-flex flex-wrap align-items-center gap-3">
                                <img src="{{ $profilePhotoUrl }}" alt="{{ $user->name }}" class="avatar-img" style="width: 72px; height: 72px; border-radius: 50%; object-fit: cover;">
                                <div class="flex-grow-1">
                                    <label class="form-label fw-semibold">Profile photo</label>
                                    <input name="profile_photo" type="file" accept="image/jpeg,image/png,image/webp" class="form-control">
                                    <div class="form-text">JPG, PNG, or WebP under 5MB.</div>
                                </div>
                            </div>
                        </div>

                        @if ($user->profile_photo_path)
                            <div class="col-12">
                                <label class="form-check d-flex align-items-center gap-2 mb-0">
                                    <input type="checkbox" name="remove_profile_photo" value="1" class="form-check-input m-0">
                                    <span>Remove current profile photo</span>
                                </label>
                            </div>
                        @endif

                        <div class="col-12">
                            <label class="form-label fw-semibold">Name</label>
                            <input name="name" type="text" value="{{ old('name', $user->name) }}" class="form-control theme-input" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Email</label>
                            <input name="email" type="email" value="{{ old('email', $user->email) }}" class="form-control theme-input" required>
                        </div>

                        <div class="col-12 d-flex flex-wrap gap-2">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-check-circle me-1" aria-hidden="true"></i>
                                Save profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="{{ $usesAdminLayout ? 'panel' : 'panel-card' }} p-4 p-lg-5">
                    <div class="mb-4">
                        <span class="theme-pill">Security</span>
                        <h2 class="h4 mt-3 mb-1">Change password</h2>
                        <p class="text-muted mb-0">Use your current password before setting a new one.</p>
                    </div>

                    <form method="post" action="{{ route('profile.password.update') }}" class="row g-3">
                        @csrf
                        @method('PUT')

                        <div class="col-12">
                            <label class="form-label fw-semibold">Current password</label>
                            <input name="current_password" type="password" class="form-control theme-input" autocomplete="current-password" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">New password</label>
                            <input name="password" type="password" class="form-control theme-input" autocomplete="new-password" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Confirm new password</label>
                            <input name="password_confirmation" type="password" class="form-control theme-input" autocomplete="new-password" required>
                        </div>

                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-lock me-1" aria-hidden="true"></i>
                                Update password
                            </button>
                        </div>
                    </form>
                </div>

                <div class="{{ $usesAdminLayout ? 'panel' : 'panel-card' }} p-4 mt-4">
                    <span class="theme-pill">{{ ucfirst($user->role) }}</span>
                    <dl class="row mt-3 mb-0">
                        <dt class="col-5 text-muted">Status</dt>
                        <dd class="col-7 text-capitalize">{{ $user->account_status }}</dd>
                        @if ($user->student_id)
                            <dt class="col-5 text-muted">Student ID</dt>
                            <dd class="col-7">{{ $user->student_id }}</dd>
                        @endif
                        @if ($user->professional_title)
                            <dt class="col-5 text-muted">Title</dt>
                            <dd class="col-7">{{ $user->professional_title }}</dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </section>
@endsection
