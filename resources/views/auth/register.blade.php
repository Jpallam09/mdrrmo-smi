<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>User Registration</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon/SMI_logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon/SMI_logo.png') }}">
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.7-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    @vite('resources/css/authCss/forms.css')
    @vite('resources/css/componentsCss/ModalCss/form-modal.css')
</head>

<body>
    <main class="container-fluid vh-100">
        <div class="row h-100">
            <x-modals.form-modal />

            <section class="col-md-7 d-flex align-items-center justify-content-center px-4"
                style="background-color: hsl(210, 20%, 98%);" role="region" aria-labelledby="reg-heading">

                <div class="login-card p-5" style="max-width: 480px; width: 100%;">

                    <div class="d-flex justify-content-between mb-4">
                        <a href="{{ route('index') }}" class="btn btn-outline-light btn-sm"
                            aria-label="Go to home page">Home</a>

                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Log In</a>
                    </div>

                    <h2 id="reg-heading" class="mb-4 text-center">Create Your Account</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <!-- Registration Form -->
                    <form action="{{ route('register.post') }}" method="POST" novalidate class="glow-container">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" id="username" name="user_name" class="form-control"
                                    placeholder="Choose a username" required minlength="3" maxlength="20"
                                    value="{{ old('user_name') }}"/>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control"
                                    placeholder="you@example.com" required value="{{ old( 'email' ) }}" />
                            </div>

                            <div class="col-md-6">
                                <label for="first-name" class="form-label">First Name</label>
                                <input type="text" id="first-name" name="first_name" class="form-control"
                                    placeholder="Enter your First name" required minlength="3" maxlength="20" value="{{  old( 'first_name' )  }}" />
                            </div>

                            <div class="col-md-6">
                                <label for="last-name" class="form-label">Last Name</label>
                                <input type="text" id="last-name" name="last_name" class="form-control"
                                    placeholder="Enter your Last name" required minlength="3" maxlength="20" value="{{ old( 'last_name' ) }}" />
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" id="phone" name="phone" class="form-control"
                                    placeholder="09xx xxxx xxx" value="{{ old('phone' ) }}" />
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control"
                                    placeholder="Create a password" required minlength="8" value="{{ old('password') }}" />
                            </div>

                            <div class="col-md-6">
                                <label for="confirm-password" class="form-label">Confirm Password</label>
                                <input type="password" id="confirm-password" name="password_confirmation"
                                    class="form-control" placeholder="Re-enter your password" required value="{{ old('password') }}" />
                            </div>
                        </div>

                        <button type="submit" class="btn btn-outline-light btn-sm w-100 mt-4"
                            aria-label="Register new user">Register</button>
                    </form>
                </div>

            </section>
        </div>
    </main>

    @vite('resources/js/componentsJs/form-modal.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
