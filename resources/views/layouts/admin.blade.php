<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#9F1239">
    <title>{{ $title ?? config('app.name', 'Amara Health') }} | {{ $pageTitle ?? 'Admin' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('themes/adminhmd/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/adminhmd/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/adminhmd/assets/css/style.css') }}?v={{ filemtime(public_path('themes/adminhmd/assets/css/style.css')) }}">
</head>
<body>
  <div class="admin-shell">
    <div class="sidebar-backdrop" data-sidebar-close></div>

    <aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
      <div class="sidebar-header">
        <a class="brand-mark" href="{{ route('dashboard') }}" aria-label="{{ config('app.name') }} dashboard">
          <span class="brand-icon brand-icon--logo">
            <img src="{{ asset('themes/adminhmd/assets/images/brand/university-of-ghana-logo.svg') }}" alt="University of Ghana logo">
          </span>
          <span class="brand-copy">
            <span class="brand-title">{{ config('app.name', 'Amara Health') }}</span>
            <span class="brand-subtitle">University of Ghana workspace</span>
          </span>
        </a>
      </div>

      <nav class="sidebar-nav">
        @php
            $currentUser = auth()->user()?->fresh();
            $role = $currentUser->role ?? 'admin';
            $isProfessional = $role === 'professional';
            $latestNotifications = $currentUser
                ? $currentUser->notifications()->latest()->limit(8)->get()
                : collect();
            $unreadNotificationCount = $currentUser
                ? $currentUser->notifications()->where('read', false)->count()
                : 0;
            $consultationNotificationCount = $currentUser
                ? $currentUser->notifications()->where('read', false)->where('type', 'like', 'consultation_%')->count()
                : 0;
            $articleNotificationCount = $currentUser
                ? $currentUser->notifications()->where('read', false)->where('type', 'like', 'article_%')->count()
                : 0;
            $forumNotificationCount = $currentUser
                ? $currentUser->notifications()->where('read', false)->where('type', 'like', 'forum_%')->count()
                : 0;
            $sidebarLinks = $isProfessional ? [
                ['route' => 'professional.dashboard', 'icon' => 'bi-speedometer2', 'label' => 'Dashboard', 'pattern' => 'professional.dashboard', 'badge' => $unreadNotificationCount],
                ['route' => 'professional.consultations.index', 'icon' => 'bi-heart-pulse', 'label' => 'Consultations', 'pattern' => 'professional.consultations.*', 'badge' => $consultationNotificationCount],
                ['route' => 'professional.forum.index', 'icon' => 'bi-chat-square-text', 'label' => 'Forum review', 'pattern' => 'professional.forum.*', 'badge' => $forumNotificationCount],
                ['route' => 'professional.articles.index', 'icon' => 'bi-journal-text', 'label' => 'Knowledge hub', 'pattern' => 'professional.articles.*', 'badge' => $articleNotificationCount],
            ] : [
                ['route' => 'admin.dashboard', 'icon' => 'bi-speedometer2', 'label' => 'Dashboard', 'pattern' => 'admin.dashboard', 'badge' => $unreadNotificationCount],
                ['route' => 'admin.consultations.index', 'icon' => 'bi-heart-pulse', 'label' => 'Consultations', 'pattern' => 'admin.consultations.*', 'badge' => $consultationNotificationCount],
                ['route' => 'admin.forum.index', 'icon' => 'bi-chat-square-text', 'label' => 'Forum', 'pattern' => 'admin.forum.*', 'badge' => $forumNotificationCount],
                ['route' => 'admin.articles.index', 'icon' => 'bi-journal-text', 'label' => 'Articles', 'pattern' => 'admin.articles.*', 'badge' => $articleNotificationCount],
                ['route' => 'admin.resources.index', 'icon' => 'bi-folder2-open', 'label' => 'Resources', 'pattern' => 'admin.resources.*', 'badge' => 0],
                ['route' => 'admin.professionals.index', 'icon' => 'bi-people', 'label' => 'Professionals', 'pattern' => 'admin.professionals.*', 'badge' => 0],
                ['route' => 'admin.settings.edit', 'icon' => 'bi-image', 'label' => 'Site settings', 'pattern' => 'admin.settings.*', 'badge' => 0],
            ];
        @endphp

        @foreach ($sidebarLinks as $link)
          <a class="nav-link {{ request()->routeIs($link['pattern']) ? 'active' : '' }}" href="{{ route($link['route']) }}" @if(request()->routeIs($link['pattern'])) aria-current="page" @endif>
            <span class="nav-icon"><i class="bi {{ $link['icon'] }}" aria-hidden="true"></i></span>
            <span class="nav-text">{{ $link['label'] }}</span>
            @if (($link['badge'] ?? 0) > 0)
              <span class="badge rounded-pill text-bg-warning ms-auto">{{ $link['badge'] }}</span>
            @endif
          </a>
        @endforeach
      </nav>

      @php
          $userName = $currentUser?->name ?: ($currentUser?->display_name ?? 'User');
          $userAvatar = $currentUser?->profile_photo_path
              ? asset('storage/'.$currentUser->profile_photo_path).'?v='.optional($currentUser->updated_at)->timestamp
              : asset('themes/adminhmd/assets/images/avatar/avatar-fallback.jpg');
      @endphp

      <div class="sidebar-footer">
        <span class="status-dot"></span>
        <span class="sidebar-footer-text">System running smoothly</span>
      </div>
    </aside>

    <div class="admin-main">
      <nav class="navbar admin-navbar navbar-expand bg-white">
        <div class="container-fluid px-3 px-lg-4">
          <button class="sidebar-toggle" type="button" data-sidebar-toggle aria-controls="adminSidebar" aria-expanded="true" aria-label="Toggle sidebar">
            <span></span>
            <span></span>
            <span></span>
          </button>

          <form class="d-none d-md-flex ms-3 flex-grow-1" role="search">
            <input class="form-control search-input" type="search" placeholder="Search workspace" aria-label="Search">
          </form>

          <div class="navbar-actions ms-auto">
            <button class="icon-button theme-toggle" type="button" data-theme-toggle aria-label="Switch color theme" title="Switch color theme">
              <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
            </button>
            <div class="dropdown">
              <button class="icon-button" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Notifications">
                @if ($unreadNotificationCount > 0)
                  <span class="notification-dot"></span>
                @endif
                <i class="bi bi-bell" aria-hidden="true"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end notification-menu">
                <div class="dropdown-header fw-bold text-body d-flex justify-content-between align-items-center gap-3">
                  <span>Notifications</span>
                  @if ($unreadNotificationCount > 0)
                    <span class="badge rounded-pill text-bg-warning">{{ $unreadNotificationCount }}</span>
                  @endif
                </div>
                @forelse ($latestNotifications as $notification)
                  <a class="dropdown-item {{ $notification->read ? '' : 'fw-semibold' }}" href="{{ route('notifications.open', $notification) }}">
                    <span class="notification-title">{{ $notification->title() }}</span>
                    <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                    <span class="d-block text-muted small">{{ $notification->displayMessage() }}</span>
                  </a>
                @empty
                  <span class="dropdown-item text-muted">No notifications yet.</span>
                @endforelse
                @if ($unreadNotificationCount > 0)
                  <div class="dropdown-divider"></div>
                  <form method="post" action="{{ route('notifications.mark-all-read') }}">
                    @csrf
                    <button class="dropdown-item text-center" type="submit">Mark all as read</button>
                  </form>
                @endif
              </div>
            </div>

            <div class="dropdown">
              <button class="profile-button dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="avatar-img avatar-sm" src="{{ $userAvatar }}" alt="{{ $userName }}">
                <span class="profile-name d-none d-sm-inline">{{ $userName }}</span>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                <li><a class="dropdown-item" href="{{ route('home') }}">View site</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button class="dropdown-item" type="submit">Sign out</button>
                  </form>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>

      <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
          @if (!empty($pageTitle) || !empty($subtitle))
            <div class="page-heading">
              <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
                <div>
                  @if (!empty($pageTitle))
                    <p class="eyebrow mb-1">Overview</p>
                    <h1 class="h3 mb-1">{{ $pageTitle }}</h1>
                  @endif
                  @if (!empty($subtitle))
                    <p class="text-muted mb-0">{{ $subtitle }}</p>
                  @endif
                </div>
              </div>
              @hasSection('page-actions')
                <div class="heading-actions">
                  @yield('page-actions')
                </div>
              @endif
            </div>
          @endif

          @if (session('status'))
            <div class="alert alert-info border-0 shadow-sm rounded-3">{{ session('status') }}</div>
          @endif

          @if ($errors->any())
            <div class="alert alert-warning border-0 shadow-sm rounded-3">
              <strong>Please fix the highlighted fields.</strong>
              <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          @yield('content')
        </div>
      </main>

      <footer class="admin-footer">
        <div class="container-fluid px-3 px-lg-4">
          <span>{{ config('app.name', 'Amara Health') }} admin workspace.</span>
          <span>{{ $pageTitle ?? 'Dashboard' }}</span>
        </div>
      </footer>
    </div>
  </div>

  <script src="{{ asset('themes/adminhmd/assets/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('themes/adminhmd/assets/js/main.js') }}?v={{ filemtime(public_path('themes/adminhmd/assets/js/main.js')) }}"></script>
</body>
</html>
