<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - {{ config('app.name', 'Public Announcements') }} - @yield('title')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        .action-btn {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            transition: all 0.2s;
        }
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .action-btn i {
            font-size: 1rem;
        }
        .btn-pro-nav {
            background-color: transparent;
            border: 2px solid #17a2b8;
            color: #17a2b8;
            padding: 8px 16px;
            transition: all 0.3s ease;
        }
        

        .btn-pro-nav:hover {
          background-color: #117a8b; /* Slightly darker shade of navbar color */
          border-color: #117a8b; /* Match border to background */
          color: #ffffff;
          transform: translateY(-1px); /* Subtle lift effect */
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Shadow for depth */
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center hover-lift" href="{{ route('admin.announcements.index') }}">
                <i class="fas fa-user-shield fa-lg me-2"></i>
                <span style="letter-spacing: 0.5px;">Admin Panel</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item {{ request()->routeIs('admin.announcements.index') ? 'active-nav-item' : '' }}">
                        <a class="nav-link d-flex align-items-center" href="{{ route('admin.announcements.index') }}">
                            <i class="fas fa-bullhorn me-1"></i> Announcements
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.subscribers.*') ? 'active' : '' }}" 
                           href="{{ route('admin.subscribers.index') }}">
                           <i class="fas fa-users me-1"></i> Subscribers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
                           href="{{ route('admin.users.index') }}">
                           <i class="fas fa-user-shield me-1"></i> Users</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center hover-lift" href="#" 
                           id="createDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-plus-circle me-2"></i> Create New
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="createDropdown">
                            <li>
                                <a class="dropdown-item d-flex align-items-center {{ request()->routeIs('admin.announcements.create') ? 'active' : '' }}" 
                                   href="{{ route('admin.announcements.create') }}">
                                    <i class="fas fa-bullhorn me-2"></i> Announcement
                                </a>
                            </li>
                            @if(auth()->user()->role === 'admin')
                            <li>
                                <a class="dropdown-item d-flex align-items-center {{ request()->routeIs('admin.users.create') ? 'active' : '' }}" 
                                   href="{{ route('admin.users.create') }}">
                                    <i class="fas fa-user-plus me-2"></i> Supervisor Account
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item me-2">
                        <a class="nav-link d-flex align-items-center hover-lift" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i> Back to Site
                        </a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn logout-button d-flex align-items-center">
                                <i class="fas fa-sign-out-alt me-1"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container" style="margin-top: 5rem;">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
