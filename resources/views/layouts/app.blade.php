<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Public Announcements') }} - @yield('title')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.css' rel='stylesheet'>
    
    <style>
        :root {
            --bs-primary: #25cffe;
            --bs-primary-rgb: 37, 207, 254;
        }
        
        .btn-primary {
            background-color: #25cffe;
            border-color: #25cffe;
        }
        
        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active {
            background-color: #1bb8e7 !important;
            border-color: #1bb8e7 !important;
        }
        
        .list-group-item.active {
            background-color: #25cffe;
            border-color: #25cffe;
        }
        
        a {
            color: #25cffe;
        }
        
        a:hover {
            color: #1bb8e7;
        }
        
        .btn-outline-primary {
            color: #25cffe;
            border-color: #25cffe;
        }
        
        .btn-outline-primary:hover {
            background-color: #25cffe;
            border-color: #25cffe;
        }
        
        .general-badge {
            background-color: #5c6d7b;
            color: white;
        }
        .btn-pro-login {
            border-width: 2px;
            border-color:rgb(0, 0, 0);
            color:rgb(0, 0, 0);
            padding: 12px 20px; /* Larger padding for a polished look */
            font-weight: 500; /* Slightly bolder text */
            border-radius: 15px; /* Rounded edges for modern look */
            transition: all 0.3s ease; /* Smooth hover transition */
        }

        .btn-pro-login:hover {
          background-color: #25cffe; /* Darker shade on hover */
          transform: translateY(-1px); /* Subtle lift effect */
          color: #ffffff;
          box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Shadow for depth */
        }
        .btn-pro-nav {
          border-width: 2px;
          color: #ffffff;
          transition: all 0.3s ease;
        }
        
        .btn-pro-nav:hover {
          background-color: #138496;
          border-color: #117a8b;
          color: #ffffff;
          transform: translateY(-1px);
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .logout-button {
          border-width: 2px;
          color: #ffffff;
          transition: all 0.3s ease;
        }
        
        .logout-button:hover {
          background-color:rgb(205, 54, 27);
          border-color:rgb(0, 0, 0);
          color: #ffffff;
          transform: translateY(-1px);
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            opacity: 0.8;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4" style="background-color: #5c6d7b;">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="/images/logo.png" alt="Logo" height="40" width="45" style="border-radius: 15px;">
                <span class="ms-2 fw-semibold">Attaouia Connect</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('announcements.*') ? 'active' : '' }}" 
                           href="{{ route('announcements.index') }}">Announcements</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('events.*') ? 'active' : '' }}" 
                           href="{{ route('events.index') }}">Events</a>
                    </li>
                </ul>
                
                @auth
                <ul class="navbar-nav">
  @if(auth()->user()->role === 'admin' || auth()->user()->role === 'supervisor')
    <li class="nav-item">
        <a class="btn btn-outline-info btn-pro-nav rounded-pill px-4 py-2 fw-medium" href="{{ route('admin.announcements.index') }}">Admin Panel</a>
    </li>
  @endif
  <li class="nav-item">
    <form action="{{ route('logout') }}" method="POST" class="d-inline">
      @csrf
      <button type="submit" class="btn btn-outline-info btn-pro-nav rounded-pill px-4 py-2 fw-medium">Logout</button>
    </form>
  </li>
</ul>
                @else
                    @if(!request()->routeIs('login'))
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="btn btn-pro-login rounded-pill px-4 py-2 fw-medium">Login</a>
                            </li>
                        </ul>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <main class="container">
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

    <footer class="bg-dark text-light mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <h5 class="mb-3 fw-semibold">Attaouia Connect</h5>
                    <p class="mb-0">Connecting our community through timely announcements and engaging events.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="social-links mb-3">
                        <a href="#" class="text-light me-3 hover-lift">
                            <i class="fab fa-facebook-f fa-lg"></i>
                        </a>
                        <a href="#" class="text-light me-3 hover-lift">
                            <i class="fab fa-twitter fa-lg"></i>
                        </a>
                        <a href="#" class="text-light hover-lift">
                            <i class="fab fa-linkedin-in fa-lg"></i>
                        </a>
                    </div>
                    <p class="mb-0">&copy; {{ date('Y') }} Attaouia Connect. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.js'></script>
    
    @stack('scripts')

    <script>
        // Password toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Password toggle moved to login page
        });
    </script>
</body>
</html>
