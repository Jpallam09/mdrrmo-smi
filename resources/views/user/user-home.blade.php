<!DOCTYPE html>
<html lang="en">
    <link rel="icon" type="image/png" href="{{ asset('favicon/SMI_logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon/SMI_logo.png') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon/SMI_logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon/SMI_logo.png') }}">

    <!-- Bootstrap & Icons -->
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.7-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Vite Custom CSS -->
    @vite('resources/css/componentscss/navbarcss/shared-navbar.css')
    @vite('resources/css/authcss/user-main-dashboard.css')

</head>

<body>
    <div class="layout d-flex">
        <x-navbar.user-navbar />

        <main>
            <div class="container my-5">

                <!-- Hero -->
                <section class="hero">
                    <h1>Welcome to the Incident Reporting System</h1>
                    <p>Your platform for safe, transparent, and accountable reporting.</p>
                    <a href="{{ route(name: 'user.report.create') }}"
                        class="btn btn-primary btn-md">
                        <i class="me-2"></i>Start Reporting
                    </a>
                </section>

                <!-- Tutorial / Steps -->
                <section class="mb-5">
                    <h2 class="section-title text-center">How It Works</h2>
                    <p class="text-center text-muted">you can click the cards for tutorials</p>
                    <div class="row g-4">
                        <div class="col-md-3 col-sm-6">
                            <div class="tutorial-step" data-bs-toggle="modal" data-bs-target="#createReportModal">
                                <i class="fa fa-file-alt"></i>
                                <h5>Create a Report</h5>
                                <p>Submit a new incident with details and attachments.</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="tutorial-step" data-bs-toggle="modal" data-bs-target="#viewReportsModal">
                                <i class="fa fa-list"></i>
                                <h5>View Reports</h5>
                                <p>Check your submitted reports anytime.</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="tutorial-step" data-bs-toggle="modal" data-bs-target="#editDeleteModal">
                                <i class="fa fa-edit"></i>
                                <h5>Edit Report</h5>
                                <p>Update your reports when needed and wait for the review.</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="tutorial-step" data-bs-toggle="modal" data-bs-target="#trackStatusModal">
                                <i class="fa fa-trash"></i>
                                <h5>Delete Report</h5>
                                <p>Submit a request to remove your report and wait for the review.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <x-modals.user-tutorial.user-tutorial />

                <!-- About -->
                <section class="about-section">
                    <h2 class="section-title">About This System</h2>
                    <p>
                        The Incident Reporting System allows citizens to easily report issues, track progress,
                        and ensure transparency in resolving community concerns.
                        It is designed to promote accountability and faster action from authorities.
                    </p>
                </section>

                <x-modals.user-side.faq />

        <!-- Contact -->
        <section class="contact-section text-center">
            <h2 class="section-title">Need Help?</h2>
            <p>If you need assistance, reach out to our support staff.</p>
            <button id="contactSupportBtn" class="btn btn-outline-primary">
                <i class="fa fa-envelope me-2"></i>Contact Support
            </button>
        </section>

            </div>
        </main>
    </div>

    <script src="{{ asset('bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js') }}"></script>
    @vite('resources/js/componentsjs/user-tutorial.js')
    @include('sweetalert::alert')
</body>

</html>
