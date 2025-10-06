<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>User Login</title>

    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.7-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    @vite('resources/css/authCss/forms.css')
    @vite('resources/css/componentsCss/ModalCss/form-modal.css')
</head>

<body>
    <main class="container-fluid vh-100">
        <div class="row h-100">
            <x-modals.form-modal />
            <!-- Right Panel -->
            <section class="col-md-7 d-flex align-items-center justify-content-center px-4"
                style="background-color: #f9fafb;" role="region" aria-labelledby="login-heading">
                <div class="login-card bg-white p-5 rounded shadow-sm" style="max-width: 420px; width: 100%;">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 id="login-heading" class="m-0">Log In to Your Account</h2>
                        <a href="{{ route('index') }}" class="btn btn-outline-light btn-sm"
                            aria-label="Go to home page">Home
                        </a>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form class="glow-container" id="loginForm" action="{{ route('login.post') }}" method="POST"
                        novalidate>
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control"
                                placeholder="you@example.com" autocomplete="email" required
                                aria-describedby="email-desc" value="{{ old('email') }}" />
                            <span id="email-desc" class="text-danger small" style="display:none;">
                                Please enter a valid email.
                            </span>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control"
                                placeholder="Enter your password" autocomplete="current-password" required
                                minlength="8" aria-describedby="password-desc" value="{{ old('password') }}" />
                            <span id="password-desc" class="text-danger small" style="display:none;">
                                Password must be at least 8 characters.
                            </span>
                        </div>
                        <button type="submit" class="btn btn-outline-light btn-sm w-100" aria-label="Log in user">Log
                            In</button>
                    </form>
                    <hr>
                    <div class="text-center mt-3">
                        <span class="text-white me-2">Don't have an account?</span>
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm">Register</a>
                    </div>

                    <div class="text-center me-3 mt-1">
                        <a class="text-white small" href="{{ route('forgot') }}">Forgot password?</a>
                    </div>
                </div>
            </section>
        </div>
    </main>
    @include('sweetalert::alert')
    @vite('resources/js/authJs/login.js')
    @vite('resources/js/componentsJs/form-modal.js')
    <!-- Bootstrap JS Bundle with Popper (optional, for Bootstrap components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
