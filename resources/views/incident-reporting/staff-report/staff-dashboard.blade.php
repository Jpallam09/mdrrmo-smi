<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Staff Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon/SMI_logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon/SMI_logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap & FontAwesome -->
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.7-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/componentscss/navbarcss/shared-navbar.css', 'resources/css/staffcss/staff-dashboard.css'])

</head>

<body>
    <div class="layout d-flex">
        <x-navbar.shared-navbar />

        <main class="page-content flex-grow-1">
            <section class="container-fluid py-4">
                <!-- Page Title -->
                <div class="row mb-4">
                    <div class="col">
                        <h1 class="page-title">Dashboard</h1>
                    </div>
                </div>

                <!-- Top Row: 3 widgets -->
                <div class="row g-3 widgets mb-3">
                    <div class="col-md-4">
                        <section class="widget">
                            <a class="widget-link">
                                <h2><i class="fas fa-file-alt"></i> Total Reports</h2>
                                <p id="totalReportsCount">{{ $totalIncidentReports }}</p>
                            </a>
                        </section>
                    </div>
                    <div class="col-md-4">
                        <section class="widget">
                            <a class="widget-link">
                                <h2><i class="fas fa-trash-alt"></i> Pending Deletion Requests</h2>
                                <p id="pendingDeletionsCount">{{ $totalPendingDeleteRequests }}</p>
                            </a>
                        </section>
                    </div>
                    <div class="col-md-4">
                        <section class="widget">
                            <a class="widget-link">
                                <h2><i class="fas fa-edit"></i> Pending Edit Requests</h2>
                                <p id="pendingUpdatesCount">{{ $totalPendingEditRequests }}</p>
                            </a>
                        </section>
                    </div>
                </div>

                <!-- Bottom Row: 2 widgets centered -->
                <div class="row g-3 widgets justify-content-center">
                    <div class="col-md-4">
                        <section class="widget">
                            <a class="widget-link">
                                <h2><i class="fas fa-check-circle"></i> Resolved Reports</h2>
                                <p id="resolvedReportsCount">{{ $totalResolvedReports }}</p>
                            </a>
                        </section>
                    </div>
                    <div class="col-md-4">
                        <section class="widget">
                            <a class="widget-link">
                                <h2><i class="fas fa-times-circle"></i> Unsuccessful response</h2>
                                <p id="unsuccessfulReportsCount">{{ $totalCanceledReports }}</p>
                            </a>
                        </section>
                    </div>
                </div>

                <div class="row mb-4 mt-4">
                    <div class="col">
                        <h2 class="page-title">Report Charts</h2>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="row g-3 mt-4">
                    <div class="col-lg-8">
                        <section class="chart-card">
                            <h3><i class="fas fa-chart-line"></i> Monthly Reports Trend</h3>
                            <canvas id="monthlyReportsChart"></canvas>
                        </section>
                    </div>
                    <div class="col-lg-4">
                        <section class="chart-card">
                            <h3><i class="fas fa-chart-pie"></i> Report Type Distribution</h3>
                            <canvas id="reportTypeChart"></canvas>
                        </section>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <script>
        window.chartRoutes = {
            monthlyTrend: "{{ route('staff.report.chart.monthlyTrend') }}",
            reportType: "{{ route('staff.report.chart.reportType') }}"
        };
    </script>
    @include('sweetalert::alert')
    @vite(['resources/js/componentsjs/navbar.js', 'resources/js/staffjs/staff-dashboard.js'])
    <!-- Bootstrap Bundle -->
    <script src="{{ asset('bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
