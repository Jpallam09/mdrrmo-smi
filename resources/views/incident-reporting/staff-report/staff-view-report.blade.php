<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff - Report Details</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon/SMI_logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon/SMI_logo.png') }}">

    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.7-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @vite('resources/css/staffcss/staff-view-reports-full-details.css')
    @vite('resources/css/componentscss/navbarcss/shared-navbar.css')

</head>

<body>
    <main class="layout">
        <x-navbar.shared-navbar />

        <section class="page-content mt-5">
            <div class="report-details-container">
                <!-- Header and Back Button -->
                <div class="header">
                    <h1 class="report-title">   {{ $report->report_title }}</h1>
                    <!-- Back to List link -->
                    <a href="{{ route('staff.report.list') }}" class="btn btn-secondary btn-sm">
                        <i class="fa-solid fa-arrow-left"></i> Back to Report List table
                    </a>
                </div>

                <!-- Feedback Section for Staff -->
                @if (in_array($report->report_status, [
                        \App\Models\IncidentReporting\IncidentReportUser::STATUS_SUCCESS,
                        \App\Models\IncidentReporting\IncidentReportUser::STATUS_CANCELED,
                    ]) && $report->feedbackComments->count())

                    <div class="Feed_back card shadow-sm border-0 mt-4 mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4 d-flex align-items-center">
                                <i class="bi bi-chat-square-text-fill text-success fs-4 me-2"></i>
                                Feedbacks
                            </h5>

                            <div class="feedback-list d-flex flex-column gap-3">
                                @foreach ($report->feedbackComments as $feedback)
                                    <div class="p-3 rounded bg-light border-start border-4 border-success shadow-sm">
                                        <div class="d-flex align-items-start gap-3">
                                            <i class="bi bi-person-circle text-success fs-4"></i>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-bold text-success">
                                                    {{ $feedback->user->user_name ?? 'Unknown User' }}
                                                    <span class="fw-normal text-muted fs-7">
                                                        ({{ $feedback->created_at->format('Y-m-d H:i') }})
                                                    </span>
                                                </h6>
                                                <p class="mb-0 text-muted fst-italic">
                                                    <i class="bi bi-chat-quote-fill me-1 text-secondary"></i>
                                                    “{{ $feedback->comment }}”
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                @endif

                <!-- Report Meta Info - Modern Table UI -->
                <div class="card mb-3 shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <i class="fa-solid fa-info-circle me-2"></i> Report Information
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row" class="w-25">Report Type</th>
                                    <td>{{ $report->report_type }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Phone Number</th>
                                    <td>{{ $report->user->phone ?? 'Unknown' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Date Submitted</th>
                                    <td>{{ $report->created_at->format('Y-m-d') }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Report Sender</th>
                                    <td>{{ $report->user_name ?? 'Unknown' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Description - Modern Card -->
                <div class="card mb-3 shadow-sm border-0">
                    <div class="card-header bg-secondary text-white">
                        <i class="fa-solid fa-align-left me-2"></i> Description
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $report->report_description }}</p>
                    </div>
                </div>


                <!-- Images -->
                <div class="report-images">
                    <h3>Attached Images</h3>
                    <div class="image-grid">
                        @if ($report->images->count())
                            <div class="attachments-grid">
                                @foreach ($report->images as $index => $image)
                                    <div>
                                        <img src="{{ asset('storage/' . $image->file_path) }}"
                                            alt="Attachment {{ $index + 1 }}" class="thumbnail"
                                            onclick="openImageModal({{ $index }})">
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-light">No attachments provided.</p>
                        @endif
                    </div>

                    <!-- Modal Viewer -->
                    <div id="imageModal" class="image-modal">
                        <span class="close-modal" onclick="closeModal()">&times;</span>
                        <span class="prev" onclick="changeImage(-1)">&#10094;</span>
                        <span class="next" onclick="changeImage(1)">&#10095;</span>
                        <img id="expandedImg" class="modal-img" src="" alt="Zoomed Image">
                        <div id="caption" class="caption-text"></div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-3">
                    <span id="reportStatus" class="d-none bt">{{ $report->report_status }}</span>
                    <a href="{{ route('staff.report.track.show', $report->id) }}"
                        class="btn btn-primary btn-sm" id="trackReportBtn">
                        <i class="fa-solid fa-check"></i> Track Report
                    </a>

                    <a href="{{ route('staff.report.exportPdf', $report->id) }}"
                        class="btn btn-outline-danger btn-sm">
                        <i class="fa-solid fa-file-pdf"></i> PDF
                    </a>
                </div>

            </div>

            </div>
        </section>
    </main>
    @include('sweetalert::alert')
    @vite('resources/js/staffjs/staff-view-reports-full-details.js')
    @vite('resources/js/componentsjs/navbar.js')
    <script src="{{ asset('bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
