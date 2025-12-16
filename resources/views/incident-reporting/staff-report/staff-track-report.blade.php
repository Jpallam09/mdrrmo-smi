    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Track Report</title>
        <link rel="icon" type="image/png" href="{{ asset('favicon/SMI_logo.png') }}">
        <link rel="shortcut icon" href="{{ asset('favicon/SMI_logo.png') }}">
        <link rel="stylesheet" href="{{ asset('bootstrap-5.3.7-dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />

        @vite('resources/css/staffcss/staff-track-report.css')
        @vite('resources/css/componentscss/navbarcss/shared-navbar.css')
    </head>

    <body>
        <main class="layout">
            <x-navbar.shared-navbar />

            <section class="page-content">
                <div class="container py-3">

                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h1 class="h3 mb-0">Track Report Location</h1>
                        <a href="{{ route('staff.report.list') }}" class="btn btn-secondary btn-sm">
                            <i class="fa-solid fa-arrow-left"></i> Back to Report list table
                        </a>
                    </div>

                    <!-- Report Details - Modern Table UI -->
                    <div class="card mb-3 shadow-sm border-0">
                        <div class="card-header bg-primary text-white">
                            <i class="fa-solid fa-file-lines me-2"></i> Report Details
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="row" class="w-25">Report Title</th>
                                        <td>{{ $report->report_title }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Type</th>
                                        <td>{{ $report->report_type }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Date Submitted</th>
                                        <td>{{ $report->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Description</th>
                                        <td>{{ $report->report_description }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Map / No Location -->
                    <div class="card mb-3">
                        <div class="card-body p-0">
                            @if ($report->latitude && $report->longitude)
                                <div id="map" class="w-100" style="height: 300px;"></div>
                            @else
                                <div
                                    class="d-flex flex-column justify-content-center align-items-center text-center p-5">
                                    <i class="fa-solid fa-location-crosshairs fa-3x mb-3 text-secondary"></i>
                                    <h5 class="text-secondary">No Location Added</h5>
                                    <p class="text-muted mb-0">This report does not have a location set.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Coordinates -->
                    <div class="row mb-3 text-center">
                        <div class="col"><strong>Latitude:</strong> <span id="currentLat">-</span></div>
                        <div class="col"><strong>Longitude:</strong> <span id="currentLng">-</span></div>
                    </div>

                    <!-- Track Button -->
                    <form id="trackReportForm" class="d-flex justify-content-center mb-3">
                        @csrf
                        <input type="hidden" name="report_id" value="{{ $report->id }}">
                        <input type="hidden" id="incidentLat" value="{{ $report->latitude }}">
                        <input type="hidden" id="incidentLng" value="{{ $report->longitude }}">

                        @if ($report->report_status !== 'success' && $report->report_status !== 'canceled')
                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                <i class="fa-solid fa-location-dot"></i> Start Tracking
                            </button>
                        @endif
                    </form>

                    @if ($report->report_status === 'success')
                        <!-- Already marked as success -->
                        <div class="alert alert-success mt-3" role="alert">
                            The Report is <strong>Successful</strong>
                        </div>
                    @elseif ($report->report_status === 'canceled')
                        <!-- Already cancelled -->
                        <div class="alert alert-danger mt-3" role="alert">
                            The Report is <strong>Unsuccessful</strong>
                        </div>
                    @else
                        <form id="successForm-{{ $report->id }}"
                            action="{{ route('staff.report.track.success', $report->id) }}" method="POST"
                            class="d-inline">
                            @csrf
                            <button type="button" class="btn btn-success btn-sm btn-success-track"
                                data-id="{{ $report->id }}">
                                <i class="fa-solid fa-check"></i> Success
                            </button>
                        </form>

                        <!-- Cancel -->
                        <form id="cancelForm-{{ $report->id }}"
                            action="{{ route('staff.report.track.cancel', $report->id) }}" method="POST"
                            class="d-inline">
                            @csrf
                            <button type="button" class="btn btn-outline-danger btn-sm btn-cancel-track"
                                data-id="{{ $report->id }}">
                                <i class="fa-solid fa-xmark"></i> Cancel
                            </button>
                        </form>
                    @endif

                    <!-- Track URL for JS -->
                    <div id="trackUrlContainer" data-track-url="{{ route('staff.report.track.create') }}">
                    </div>
                    <!-- Response -->
                    <div id="responseMessage" class="text-center"></div>

                </div>
            </section>
        </main>

        <!-- Leaflet JS -->
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
        <!-- Bootstrap JS -->
        <script src="{{ asset('bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js') }}"></script>
        <!-- Custom JS -->
        @vite('resources/js/staffjs/staff-track-report.js')
        @vite('resources/js/componentsjs/navbar.js')
        @include('sweetalert::alert')
    </body>

    </html>
