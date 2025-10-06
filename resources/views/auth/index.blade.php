<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Municipality Document Request & Incident Reporting</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon/SMI_logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon/SMI_logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite('resources/css/authCss/index.css')
</head>

<body>
    <section id="introSection" class="vh-100 d-flex flex-column bg-dark text-white mb-5">
        <nav class="navbar navbar-expand-lg navbar-dark bg-transparent fixed-top transparent-navbar">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <a class="navbar-brand d-flex align-items-center gap-2" href="#">
                    <img src="{{ asset('images/SMI_logo.png') }}" height="40" alt="Municipality Logo" />
                    <strong class="brand-text">MDRRMO San Mateo Isabela</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarExample01" aria-controls="navbarExample01" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarExample01">
                    <ul class="navbar-nav mb-2 mb-lg-0 text-center">
                        <li class="nav-item"><a class="nav-link active" href="#introSection">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#featuresSection">Features</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    </ul>
                    <ul class="navbar-nav list-inline mb-0 ms-lg-3">
                        <li class="nav-item"><a class="nav-link" href="https://www.facebook.com/gladys.tabag.5/"
                                target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                        <li class="nav-item"><a class="nav-link" href="#faq"><i
                                    class="fas fa-question-circle"></i></a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <section class="bg-dark text-white vh-100 d-flex align-items-center" aria-label="Hero section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start fade-in delay-1">
                        <h1 class="display-4 fw-bold mb-3">Welcome to the Municipal Disaster Risk Reduction and
                            Management Office Portal</h1>
                        <p class="lead mb-4">Report incidents quickly and securely.</p>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg shadow start">Get Started</a>
                    </div>
                    <div class="col-md-6 text-center fade-in delay-2">
                        <img src="{{ asset('images/SMI_MDRRMO_01.jpg') }}" alt="Incident Reporting"
                            class="img-fluid rounded shadow-lg" />
                    </div>
                </div>
            </div>
        </section>
    </section>

    <section id="featuresSection" class="py-5 bg-light" aria-label="Features">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-md-4">
                    <div class="card shadow-sm rounded-3 h-100 border-0 py-5 px-4">
                        <div class="card-body d-flex flex-column align-items-center">
                            <i class="fas fa-shield-alt fa-3x mb-4 text-primary"></i>
                            <h5 class="card-title fw-bold">Secure & Confidential</h5>
                            <p class="card-text text-muted text-center">Your reports are handled with full privacy and
                                security.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm rounded-3 h-100 border-0 py-5 px-4">
                        <div class="card-body d-flex flex-column align-items-center">
                            <i class="fas fa-bolt fa-3x mb-4 text-primary"></i>
                            <h5 class="card-title fw-bold">Fast Reporting</h5>
                            <p class="card-text text-muted text-center">Submit incidents quickly without unnecessary
                                delays.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm rounded-3 h-100 border-0 py-5 px-4">
                        <div class="card-body d-flex flex-column align-items-center">
                            <i class="fas fa-headset fa-3x mb-4 text-primary"></i>
                            <h5 class="card-title fw-bold">24/7 Monitoring</h5>
                            <p class="card-text text-muted text-center">Our team monitors reports around the clock to
                                take immediate action.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main>
        <section id="hero" class="hero-section py-5 bg-light" aria-label="Workplace services overview">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 fade-in delay-1">
                        <h1 class="display-4 fw-bold mb-4">Streamline Your Workplace Processes</h1>
                        <p class="lead mb-4">Our comprehensive system provides two essential services to keep your
                            organization running smoothly and ensure a safe working environment for everyone.</p>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <h5 class="fw-semibold">Track your Reports</h5>
                                <p class="text-muted">A simple way for users to track report status.</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h5 class="fw-semibold">Incident Reporting</h5>
                                <p class="text-muted">A secure way for users to report workplace incidents.</p>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex">
                            <a href="#AboutUs" class="btn btn-primary btn-lg me-md-2 shadow">About Us</a>
                        </div>
                    </div>

                    <div class="col-lg-6 mt-4 mt-lg-0 fade-in delay-2">
                        <img src="{{ asset('images/SMI_MDRRMO_02.jpg') }}" alt="Modern workplace interface"
                            class="img-fluid rounded shadow" />
                    </div>
                </div>
            </div>
        </section>

        <section id="faq" class="faq-section py-5" aria-label="Frequently Asked Questions">
            <div class="container">
                <h2 class="text-center mb-5">Frequently Asked Questions</h2>
                <x-modals.user-side.faq />
            </div>
        </section>
    </main>

    <footer id="AboutUs" class="bg-light text-dark border-top py-5" aria-label="Footer">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-3">Municipal Disaster Risk Reduction and Management Office</h5>
                    <p class="text-muted">We are committed to building resilient communities by integrating disaster
                        risk reduction into workplace systems, ensuring preparedness, and fostering safety-first
                        initiatives across all sectors.</p>
                    <p class="small text-muted mb-0 fst-italic">"Prepared today, safe tomorrow."</p>
                </div>
                <div class="col-lg-4 text-center">
                    <h6 class="fw-semibold mb-3">Quick Links</h6>
                    <ul class="list-unstyled d-inline-block text-start">
                        <li class="mb-2"><a href="#introSection" class="link-dark link-opacity-75-hover">Back to
                                Top</a></li>
                        <li class="mb-2"><a href="#AboutUs" class="link-dark link-opacity-75-hover">About Us</a>
                        </li>
                        <li class="mb-2"><a href="#faq" class="link-dark link-opacity-75-hover">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 text-lg-end text-center">
                    <h6 class="fw-semibold mb-3">Get in Touch</h6>
                    <p class="mb-1"><i class="fa fa-envelope me-2"></i><a
                            href="mailto:Sanmateomdrrmorescue309@gmail.com"
                            class="link-dark link-opacity-75-hover">Sanmateomdrrmorescue309@gmail.com</a></p>
                    <p class="mb-1"><i class="fa fa-phone me-2"></i>Globe: 0926-280-3804</p>
                    <p class="mb-1"><i class="fa fa-phone me-2"></i>SMART: 0961-541-7453</p>
                    <p class="mb-1"><i class="fa fa-map-marker-alt me-2"></i>BARANGAY 3-SAN MATEO, ISABELA</p>
                    <div class="d-flex justify-content-center justify-content-lg-end gap-3 mt-3">
                        <a href="https://www.facebook.com/gladys.tabag.5/"
                            class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center"
                            style="width:40px; height:40px;" aria-label="Facebook"><i
                                class="fab fa-facebook-f"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="d-flex flex-column flex-md-row justify-content-between text-center">
                <small class="text-muted">&copy; 2025 Municipal Disaster Risk Reduction and Management Office. All
                    rights reserved.</small>
                <small class="text-muted"><a href="#privacy" class="link-dark link-opacity-75-hover">Privacy
                        Policy</a> • <a href="#terms" class="link-dark link-opacity-75-hover">Terms of
                        Service</a></small>
            </div>
        </div>
    </footer>

    <div class="bg-dark text-white text-center py-2">
        <small>© 2025 Your System. All Rights Reserved.</small>
    </div>

    @include('sweetalert::alert')
    @vite('resources/js/authjs/index.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
