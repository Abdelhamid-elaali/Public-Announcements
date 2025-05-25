@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-75">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-transparent border-0 text-center py-4">
                    <h3 class="text-center fw-light mb-0">
                        <i class="fas fa-user-circle fa-2x mb-3 text-info"></i><br>
                        Welcome Back
                    </h3>
                </div>

                <div class="card-body px-5 py-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label small fw-medium">{{ __('Email Address') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-envelope text-muted"></i>
                                </span>
                                <input id="email" type="email" 
                                       class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" 
                                       required autocomplete="email" autofocus 
                                       placeholder="Enter your email">
                            </div>
                            @error('email')
                                <span class="invalid-feedback d-block mt-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
    <label for="password" class="form-label small fw-medium">{{ __('Password') }}</label>
    <div class="input-group">
        <span class="input-group-text bg-light border-end-0">
            <i class="fas fa-lock text-muted"></i>
        </span>
        <input id="password" type="password" 
               class="form-control border-start-0 @error('password') is-invalid @enderror" 
               name="password" required 
               autocomplete="current-password"
               placeholder="Enter your password">
        <span class="input-group-text bg-light border-start-0" id="togglePassword" style="cursor: pointer;">
            <i class="fas fa-eye text-muted"></i>
        </span>
    </div>
    @error('password')
        <span class="invalid-feedback d-block mt-1" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" 
                                       id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label small" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" 
                                    class="btn btn-pro-login py-2 position-relative overflow-hidden login-btn"
                                    style="transition: all 0.3s ease;">
                                <span class="d-flex align-items-center justify-content-center">
                                    <i class="fas fa-sign-in-alt me-2"></i>
                                    <span class="fw-medium" style="letter-spacing: 0.5px;">{{ __('Login') }}</span>
                                </span>
                            </button>
                        </div>

                        <style>
                            .login-btn {
                                border: none;
                                background: linear-gradient(135deg, #25cffe, #138496);
                                color: white;
                                font-size: 1.1rem;
                                border-radius: 12px;
                                box-shadow: 0 4px 15px rgba(37, 207, 254, 0.2);
                            }

                            .login-btn:hover {
                                transform: translateY(-2px);
                                box-shadow: 0 6px 20px rgba(37, 207, 254, 0.3);
                                color: white;
                            }

                            .login-btn:active {
                                transform: translateY(0);
                                box-shadow: 0 2px 10px rgba(37, 207, 254, 0.2);
                            }

                            .login-btn::before {
                                content: '';
                                position: absolute;
                                top: 0;
                                left: -100%;
                                width: 100%;
                                height: 100%;
                                background: linear-gradient(120deg, transparent, rgba(255,255,255,0.3), transparent);
                                transition: 0.5s;
                            }

                            .login-btn:hover::before {
                                left: 100%;
                            }
                        </style>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Initialize password toggle functionality
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        if (toggleBtn && passwordInput) {
            toggleBtn.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();

                // Toggle password visibility
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    toggleBtn.querySelector('i').className = 'fas fa-eye-slash text-muted';
                } else {
                    passwordInput.type = 'password';
                    toggleBtn.querySelector('i').className = 'fas fa-eye text-muted';
                }
            };
        }
    });
</script>
@endpush
@endsection
