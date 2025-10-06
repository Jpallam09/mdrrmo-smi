<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Forgot Password</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon/SMI_logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon/SMI_logo.png') }}">

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
            <section class="col-md-7 d-flex align-items-center justify-content-center px-4 max-width"
                style="background-color: #f9fafb;" role="region" aria-labelledby="login-heading">
                <div class="login-card bg-white p-5 rounded shadow-sm" style="max-width: 420px; width: 100%;">
                    <h2 id="login-heading" class="mb-4">Forgot Password</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ request('email') }}">

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" name="password" id="password" class="form-control" required
                                minlength="8" placeholder="New Password" value="{{ old('password') }}">
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" required minlength="8" placeholder="Confirm Password"
                                value="{{ old('password_confirmation') }}">
                        </div>

                        <button type="submit" class="btn btn-outline-light w-100">
                            <i class="text-white fas fa-unlock-alt text me-1"></i>Reset Password</button>
                    </form>

                    <hr>
                    <div class="text-center mt-3">
                        <span class="text-white me-2">Don't have an account?</span>
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm">Register</a>
                    </div>

                    <div class="text-center me-3 mt-1">
                        <a class="text-white small" href="{{ route('login') }}">Login</a>
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
