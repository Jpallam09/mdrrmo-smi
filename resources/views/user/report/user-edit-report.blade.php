<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Incident Report Details</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon/SMI_logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon/SMI_logo.png') }}">

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.7-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite('resources/css/usercss/edit-reports.css')
    @vite('resources/css/componentscss/navbarcss/shared-navbar.css')

</head>

<body>
    <main class="layout d-flex">
        <x-navbar.user-navbar />

        <section class="page-content flex-grow-1 px-4">
            <!-- Header -->
            <div class="header d-flex justify-content-between align-items-center mb-4">
                <h1>Edit Your Report</h1>
                <a href="{{ route('user.report.view', $report->id) }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i>
                    Back to report
                </a>
            </div>

            {{-- Edit request form --}}
            <form id="editRequestForm" action="{{ route('user.report.requestUpdate', $report->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="report-card">
                    <div class="report-header">
                        <div>
                            <div class="mb-3">
                                <label for="title" class="form-label fw-semibold d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-file-signature text-muted"></i> Report Title
                                </label>
                                <input type="text" id="title" name="title" class="form-control shadow-sm"
                                    value="{{ old('title', $report->report_title) }}"
                                    placeholder="Enter the report title..." required>
                            </div>


                            <div><i class="fa-solid fa-calendar-day text-muted"></i>
                                <label>Date</label>
                                <input type="date" id="incidentDate" name="requested_report_date"
                                    class="form-control shadow-sm"
                                    value="{{ old('requested_report_date', $report->report_date) }}"
                                    required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="incidentType" class="form-label fw-semibold d-flex align-items-center gap-2">
                                <i class="fa-solid fa-list text-muted"></i> Incident Type
                            </label>
                            <select id="incidentType" name="incident_type" class="form-select shadow-sm" required>
                                <option disabled {{ old('incident_type', $report->incident_type) ? '' : 'selected' }}>
                                    Select a type</option>
                                <option value="Safety"
                                    {{ old('incident_type', $report->incident_type) === 'Safety' ? 'selected' : '' }}>
                                    Safety</option>
                                <option value="Operational"
                                    {{ old('incident_type', $report->incident_type) === 'Operational' ? 'selected' : '' }}>
                                    Operational</option>
                                <option value="Security"
                                    {{ old('incident_type', $report->incident_type) === 'Security' ? 'selected' : '' }}>
                                    Security</option>
                                <option value="Environmental"
                                    {{ old('incident_type', $report->incident_type) === 'Environmental' ? 'selected' : '' }}>
                                    Environmental</option>
                            </select>
                        </div>

                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="incidentDescription" class="form-label fw-semibold d-flex align-items-center gap-2">
                            <i class="fa-solid fa-align-left text-muted"></i> Description
                        </label>
                        <textarea class="form-control shadow-sm" id="incidentDescription" name="incident_description" rows="4"
                            class="form-control shadow-sm" placeholder="Describe the incident in detail..." required>{{ old('incident_description', $report->report_description) }}</textarea>
                    </div>

                    <div class="card mb-4 p-3 shadow-sm">
                        <div class="row g-3 align-items-center">

                            <div class="col-md-7">
                                <label class="form-label">Incident Location<small id="coordsHelpControls"
                                        class="text-muted mb-0">(Optional)</small></label>
                                <div id="mapControls" class="w-100 h-100 rounded-3 bg-light"></div>
                                <div class="d-flex justify-content-start align-items-center mt-2 gap-2">
                                    <button type="button" id="locateBtn" class="btn btn-primary btn-sm rounded-pill">
                                        <i class="fa-solid fa-location-crosshairs"></i> Use My Location
                                    </button>

                                    <a href="javascript:void(0);" id="resetButton"
                                        class="btn btn-outline-secondary btn-sm rounded-pill px-3 d-none">
                                        <i class="fa-solid fa-rotate-left"></i> Reset Location
                                    </a>
                                </div>
                            </div>

                            <hr class="my-3">

                            <!-- Map Preview Row -->
                            <div class="col-12 mt-3">
                                <label class="form-label">Location Preview</label>
                                <div id="mapPreview" class="w-100 rounded-3 border bg-light" style="height: 250px;">
                                </div>
                                <small id="coordsHelpPreview" class="text-muted">Latitude & Longitude will auto-fill
                                    here.</small>
                            </div>

                            <input type="hidden" name="latitude" id="latitude"
                                value="{{ old('latitude', $report->latitude) }}">
                            <input type="hidden" name="longitude" id="longitude"
                                value="{{ old('longitude', $report->longitude) }}">
                        </div>

                        <!-- Attachments -->
                        <div class="attachments-section card shadow-sm p-3 mb-4">
                            <h3 class="h5 mb-3 d-flex align-items-center gap-2">
                                <i class="fa-solid fa-paperclip text-muted"></i> Attachments
                            </h3>

                            <!-- Existing Images Grid -->
                            <div class="attachments-grid d-flex flex-wrap gap-3 mb-3" id="attachmentsGrid">
                                @foreach ($report->images as $image)
                                    <div
                                        class="position-relative attachment-item border rounded shadow-sm p-1 bg-light">
                                        <img src="{{ asset('storage/' . $image->file_path) }}"
                                            alt="Report Attachment" class="attachment-thumb rounded">
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 rounded-circle shadow"
                                            onclick="removeExistingImage({{ $image->id }}, this)">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Upload New Images -->
                            <div class="upload-section">
                                <label for="requested_image"
                                    class="form-label fw-semibold d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-upload text-success"></i> Add New Images
                                </label>
                                <input type="file" name="requested_image[]" id="requested_image" accept="image/*"
                                    multiple class="form-control shadow-sm">
                                <div class="form-text text-muted">Select one or more images (JPG, PNG, etc.)</div>
                                <div id="previewContainer" class="d-flex flex-wrap gap-2 mt-2"></div>
                            </div>
                        </div>

                        <div class="mb-3 mt-3 reason-section">
                            <label for="reason" class="form-label fw-semibold d-flex align-items-center gap-2">
                                <i class="fa-solid fa-pen-to-square text-muted"></i> REASON FOR EDIT
                            </label>
                            <textarea name="reason" id="reason" rows="3" class="form-control shadow-sm"
                                placeholder="Explain why you want to edit this report..." required>{{ old('reason', $report->reason) }}</textarea>
                        </div>

                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-sm mb-2" id="updateReportBtn">
                    <i class="fas fa-check-circle me-1"></i>
                    Update Report
                </button>
            </form>

            <!-- Cancel Editing Button -->
            <button type="button" class="btn btn-outline-danger btn-sm w-auto" id="cancelEditButton"
                data-url="{{ route('user.report.view', $report->id) }}">
                <i class="fas fa-times-circle me-1"></i>
                Cancel Editing
            </button>

            <!-- Modal Viewer -->
            <div id="imageModal" class="image-modal">
                <span class="close" id="modalCloseBtn">&times;</span>
                <img class="modal-content" id="modalImage" />
                <div id="caption"></div>
                <span class="prev" id="modalPrevBtn">&#10094;</span>
                <span class="next" id="modalNextBtn">&#10095;</span>
            </div>
    </main>
    <script src="{{ asset('bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @vite('resources/js/userjs/edit-reports.js')
    @vite('resources/js/componentsjs/navbar.js')
    @vite('resources/js/userjs/edit-reports-location.js')
    @include('sweetalert::alert')
</body>

</html>
