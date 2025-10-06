<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Incident Reporting Platform</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon/SMI_logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon/SMI_logo.png') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.7-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    @vite('resources/css/usercss/user-incident-reporting.css')
    @vite('resources/css/componentscss/navbarcss/shared-navbar.css')
</head>

<body>
    <main class="layout">
        <x-navbar.user-navbar />

        <section class="page-content">
            <section id="report" class="report-form-section" aria-label="Incident report form">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-primary mb-2">Report an Incident</h2>
                    <p class="text-muted mb-0">Please provide detailed information below to help us address the issue
                        swiftly.</p>
                </div>

                <hr class="my-4 border-primary">

                <form action="{{ route('user.report.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- Incident Title -->
                    <div class="mb-3">
                        <label for="incident-title" class="form-label">
                            <i class="fa fa-file-signature text-muted"></i> Incident Title
                        </label>
                        <input type="text" class="form-control" id="incident-title" name="report_title"
                            placeholder="Brief title describing the report" required value="{{ old('report_title') }}">
                    </div>

                    <!-- Incident Date -->
                    <div class="mb-3">
                        <label for="incident-date" class="form-label">
                            <i class="fa fa-calendar-day text-muted"></i> Date of Incident
                        </label>
                        <input type="date" class="form-control" id="incident-date" name="report_date" required
                            value="{{ old('report_date') }}">
                    </div>

                    <!-- Report Type -->
                    <div class="mb-3">
                        <label for="incident-type" class="form-label">
                            <i class="fa-solid fa-list text-muted"></i> Report Type
                        </label>
                        <select class="form-select" id="incident-type" name="report_type" required>
                            <option value="" disabled selected>Select type</option>
                            <option value="Safety">Safety</option>
                            <option value="Security">Security</option>
                            <option value="Operational">Operational</option>
                            <option value="Environmental">Environmental</option>
                        </select>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="incidentDescription" class="form-label">
                            <i class="fa-solid fa-align-left text-muted"></i> Description
                        </label>
                        <textarea class="form-control" id="incidentDescription" name="report_description"
                            placeholder="Detailed description of the incident (you can manually include the incident location here)" required>{{ old('report_description') }}</textarea>
                    </div>
                    <div class="card mb-4 p-3 shadow-sm">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-7">
                                <label class="form-label">
                                    Incident Location <small class="text-muted">(Optional)</small>
                                </label>
                                <div class="d-flex flex-wrap gap-2 mt-2">
                                    <!-- Use My Location Button -->
                                    <button type="button" id="locateBtn" class="btn btn-primary btn-sm rounded-pill">
                                        <i class="fa-solid fa-location-crosshairs"></i> Use My Location
                                    </button>

                                    <!-- Reset Button (hidden initially) -->
                                    <a href="javascript:void(0);" id="resetButton"
                                        class="btn btn-outline-secondary btn-sm rounded-pill px-3 d-none">
                                        <i class="fa-solid fa-rotate-left"></i> Reset Location
                                    </a>
                                </div>
                            </div>
                        </div>

                        <hr class="my-3">

                        <!-- Map Preview -->
                        <div class="col-12 mt-3">
                            <label class="form-label">Location Preview</label>
                            <div id="mapPreview" class="w-100 rounded-3 border bg-light" style="height: 250px;"></div>
                            <small id="coordsHelpPreview" class="text-muted">Latitude & Longitude will auto-fill
                                here.</small>
                        </div>

                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-3">
                        <label for="incident-image" class="form-label fw-semibold d-flex align-items-center gap-2">
                            <i class="fa-solid fa-upload text-success"></i> Add New Images
                        </label>
                        <input type="file" class="form-control" id="incident-image" name="report_image[]"
                            accept="image/*" multiple>
                        <div class="form-text text-muted">Select one or more images (JPG, PNG, etc.)</div>
                        <div id="previewContainer" class="d-flex flex-wrap gap-2 mt-2"></div>
                    </div>

                    <!-- Image Modal -->
                    <div id="imageModal" class="image-modal">
                        <span id="closeModal" class="close-modal">&times;</span>
                        <img id="modalImage" class="modal-content" src="" alt="Enlarged image">
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-md" aria-label="Submit Incident Report">
                            Submit Report
                        </button>
                    </div>
                </form>
            </section>
        </section>
    </main>

    <script src="{{ asset('bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @vite('resources/js/userjs/user-incident-reporting.js')
    @vite('resources/js/componentsjs/navbar.js')
    @vite('resources/js/userjs/user-incident-reporting-location.js')
    @include('sweetalert::alert')
</body>

</html>
