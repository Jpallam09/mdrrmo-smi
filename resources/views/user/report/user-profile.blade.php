<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon/SMI_logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon/SMI_logo.png') }}">

    {{-- Bootstrap & Icons --}}
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.7-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    {{-- Vite CSS --}}
    @vite('resources/css/usercss/user-profile.css')
    @vite('resources/css/componentscss/navbarcss/shared-navbar.css')
</head>

<body>
    <div class="layout d-flex">
        <x-navbar.user-navbar />

        <div class="page-content flex-grow-1 pt-5 px-4">
            <div class="container py-4">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <div class="card shadow-sm rounded">
                            <div class="card-body p-4">
                                <h2 class="card-title text-center mb-4">Edit Profile</h2>

                                {{-- Profile Form --}}
                                <form id="editProfileForm" method="POST"
                                    action="{{ route('user.report.profile.update') }}"
                                    enctype="multipart/form-data">
                                    @csrf

                                    {{-- Avatar --}}
                                    <div class="d-flex justify-content-center mb-4">
                                        <div class="text-center">

                                            {{-- Fixed square, circular frame --}}
                                            <div class="rounded-circle overflow-hidden border border-3 border-primary mb-2 mx-auto"
                                                style="width: 200px; height: 200px;">
                                                <img id="profilePicture"
                                                    src="{{ $user->profile_picture ? asset('storage/profile_pictures/' . $user->profile_picture) : asset('images/pfp.png') }}"
                                                    data-default="{{ $user->profile_picture ? asset('storage/profile_pictures/' . $user->profile_picture) : asset('images/pfp.png') }}"
                                                    alt="User Profile Picture" class="w-100 h-100 object-fit-cover">
                                            </div>

                                            {{-- File input + Reset in one row --}}
                                            <div class="d-flex gap-2 mt-1">
                                                <input type="file" id="profilePictureInput" name="profile_picture"
                                                    accept="image/*" class="form-control form-control-sm">
                                                <button type="button" id="resetProfilePicture"
                                                    class="btn btn-sm btn-outline-secondary d-none">
                                                    Reset
                                                </button>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        {{-- First Name --}}
                                        <div class="col-12 col-md-6">
                                            <label for="first_name" class="form-label">First Name</label>
                                            <input type="text" id="first_name" name="first_name"
                                                value="{{ old('first_name', $user->first_name) }}" class="form-control"
                                                required>
                                        </div>

                                        {{-- Last Name --}}
                                        <div class="col-12 col-md-6">
                                            <label for="last_name" class="form-label">Last Name</label>
                                            <input type="text" id="last_name" name="last_name"
                                                value="{{ old('last_name', $user->last_name) }}" class="form-control"
                                                required>
                                        </div>

                                        {{-- Username --}}
                                        <div class="col-12">
                                            <label for="user_name" class="form-label">Username</label>
                                            <input type="text" id="user_name" name="user_name"
                                                value="{{ old('user_name', $user->user_name) }}" class="form-control"
                                                required>
                                        </div>

                                        {{-- Email (readonly) --}}
                                        <div class="col-12">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" id="email" name="email"
                                                value="{{ $user->email }}" class="form-control" readonly>
                                        </div>

                                        {{-- Phone --}}
                                        <div class="col-12">
                                            <label for="phone" class="form-label">Phone</label>
                                            <input type="text" id="phone" name="phone"
                                                value="{{ old('phone', $user->phone) }}" class="form-control">
                                        </div>

                                        {{-- Buttons --}}
                                        <div class="d-flex justify-content-between mt-4 gap-2">
                                            <button type="button" class="btn btn-outline-secondary flex-fill"
                                                onclick="window.location.href='{{ route('user.report.home') }}'">
                                                Back to Dashboard
                                            </button>
                                            <button type="submit" class="btn btn-primary flex-fill">Save
                                                Changes</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bootstrap JS --}}
            <script src="{{ asset('bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js') }}"></script>
            @vite('resources/js/componentsjs/navbar.js')
            @vite('resources/js/userjs/user-profile.js')
            @include('sweetalert::alert')
        </div>
    </div>
</body>

</html>
