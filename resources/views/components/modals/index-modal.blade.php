<section id="introSection" class="vh-100 d-flex flex-column bg-dark text-white mb-5">
    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent fixed-top transparent-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" aria-label="Homepage">
                <img src="{{ asset('images/SMI_logo.png') }}" height="40" class="d-inline-block align-text-top" />
                <strong>Municipality of San Mateo</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarExample01"
                aria-controls="navbarExample01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarExample01">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="#top" id="homeLink">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#hero" data-bs-toggle="tooltip" data-bs-placement="bottom" title="See Features">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                </ul>
                <ul class="navbar-nav list-inline">
                    <li class="nav-item"><a class="nav-link" href="https://facebook.com/municipality" target="_blank"><i
                                class="fab fa-facebook-f"></i></a></li>
                    <li class="nav-item"><a class="nav-link" href="https://twitter.com/municipality" target="_blank"><i
                                class="fab fa-twitter"></i></a></li>
                    <li class="nav-item">
                        <a class="nav-link faq-link" href="#faq" data-bs-toggle="tooltip" data-bs-placement="bottom"
                            title="Go to FAQ">
                            <i class="fas fa-question-circle"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

   <div class="container-fluid p-0">
    <!-- Hero Section -->
    <section class="bg-dark text-white vh-100 d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center">
                <!-- Text Column -->
                <div class="col-md-6 text-center text-md-start">
                    <h1 class="display-4 fw-bold mb-3">Welcome to the Municipality Incident Reporting Portal</h1>
                    <p class="lead mb-4">Report crimes and incidents quickly and securely.</p>
                </div>
                <!-- Image / Illustration Column -->
                <div class="col-md-6 text-center">
                    <img src="{{ asset('images/hero-incident.svg') }}" alt="Incident Reporting" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-md-4">
                    <div class="card shadow-sm rounded-3 h-100 border-0">
                        <div class="card-body">
                            <img src="{{ asset('images/icons/secure.svg') }}" alt="Secure" class="mb-3" width="60">
                            <h5 class="card-title fw-bold">Secure & Confidential</h5>
                            <p class="card-text">Your reports are handled with full privacy and security.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm rounded-3 h-100 border-0">
                        <div class="card-body">
                            <img src="{{ asset('images/icons/fast.svg') }}" alt="Fast" class="mb-3" width="60">
                            <h5 class="card-title fw-bold">Fast Reporting</h5>
                            <p class="card-text">Submit incidents quickly without unnecessary delays.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm rounded-3 h-100 border-0">
                        <div class="card-body">
                            <img src="{{ asset('images/icons/support.svg') }}" alt="Support" class="mb-3" width="60">
                            <h5 class="card-title fw-bold">24/7 Monitoring</h5>
                            <p class="card-text">Our team monitors reports around the clock to take immediate action.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</section>

</section>
