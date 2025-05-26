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
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
    
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

        .brand-text {
            font-family: 'Quicksand', sans-serif;
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: 0.8px;
            color: #25cffe;
            text-shadow: 1px 1px 1px rgba(0,0,0,0.2);
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
            border-width: 4px;
            border-color: #25cffe;
            background-color:rgb(189, 194, 199);
            color:black;
            padding: 12px 20px; /* Larger padding for a polished look */
            font-weight: 500; /* Slightly bolder text */
            border-radius: 15px; /* Rounded edges for modern look */
            transition: all 0.3s ease; /* Smooth hover transition */
        }

        .btn-pro-login:hover {
          background-color: #25cffe; /* Darker shade on hover */
          transform: translateY(-1px); /* Subtle lift effect */
          border-width: 4px;
          border-color: rgb(189, 194, 199);
          color: black;
          box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Shadow for depth */
        }
        .btn-pro-nav {
          border-width: 2px;
          color: #ffffff;
          transition: all 0.3s ease;
        }
        
        .btn-pro-nav:hover {
          background-color: #138496;
          border-color: #138496;
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
            transform: translateY(-0px);
            opacity: 0.9;
        }

        .nav-item {
            position: relative;
            margin: 0 5px;
        }

        .nav-item::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #25cffe;
            transition: width 0.3s ease;
        }

        .nav-item:hover::after {
            width: 100%;
        }

        .nav-link {
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #25cffe !important;
        }

        .navbar {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .active-nav-item::after {
            width: 100%;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4 bg-dark shadow-sm sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center hover-lift" href="{{ route('home') }}">
                <img src="/images/logo.png" alt="Logo" height="40" width="45" 
                     style="border-radius: 15px; transition: transform 0.3s ease;" 
                     onmouseover="this.style.transform='scale(1.1)'" 
                     onmouseout="this.style.transform='scale(1)'">
                <span class="ms-2 brand-text">Attaouia Connect</span>
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
                    <li class="nav-item {{ request()->routeIs('admin.*') ? 'active-nav-item' : '' }}">
                        <a class="nav-link d-flex align-items-center" href="{{ route('admin.announcements.index') }}">
                            <i class="fas fa-user-shield me-1"></i> Admin Panel
                        </a>
                    </li>
                    <li class="nav-item ms-2">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn logout-button d-flex align-items-center">
                                <i class="fas fa-sign-out-alt me-1"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
                @else
                    @if(!request()->routeIs('login'))
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="btn btn-pro-nav d-flex align-items-center">
                                    <i class="fas fa-sign-in-alt me-1"></i> Login
                                </a>
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
        <div class="container-fluid">
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
