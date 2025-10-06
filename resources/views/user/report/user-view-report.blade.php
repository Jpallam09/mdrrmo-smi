<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Incident Report Details</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon/SMI_logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon/SMI_logo.png') }}">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.7-dist/css/bootstrap.min.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @vite('resources/css/usercss/view-reports.css')
    @vite('resources/css/componentscss/navbarCss/shared-navbar.css')

</head>

<body>
    <div class="layout d-flex">
        <x-navbar.user-navbar />

        <main class="page-content flex-grow-1 px-4">
            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 m-0">Report Details</h1>
                <a href="{{ route('user.report.home') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i>
                    Back to report List table
                </a>
            </div>

            <!-- Feedback Section -->
            @if (in_array($report->report_status, [
                    \App\Models\IncidentReporting\IncidentReportUser::STATUS_SUCCESS,
                    \App\Models\IncidentReporting\IncidentReportUser::STATUS_CANCELED,
                ]))
                @php
                    $userFeedback = $report->feedbackComments->where('user_id', auth()->id())->first();
                @endphp

                <div class="Feed_back card shadow-sm border-0 mt-4 mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4 d-flex align-items-center">
                            <i class="bi bi-chat-square-heart-fill text-danger fs-4 me-2"></i>
                            We value your feedback
                        </h5>

                        @if ($userFeedback)
                            <!-- Show submitted feedback -->
                            <div class="p-3 rounded bg-light border-start border-4 border-success shadow-sm">
                                <div class="d-flex align-items-start gap-3">
                                    <i class="bi bi-emoji-smile-fill text-success fs-4"></i>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-bold text-success d-flex align-items-center gap-2">
                                            <i class="bi bi-check-circle-fill"></i>
                                            Thank you for your feedback!
                                        </h6>
                                        <p class="mb-0 text-muted fst-italic">
                                            <i class="bi bi-chat-quote-fill me-1 text-secondary"></i>
                                            “{{ $userFeedback->comment }}”
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Feedback Form -->
                            <form action="{{ route('user.report.feedback.store', $report->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="comment"
                                        class="form-label fw-semibold d-flex align-items-center gap-2">
                                        <i class="bi bi-pencil-square text-primary"></i> Your Feedback
                                    </label>
                                    <textarea name="comment" id="comment" rows="3" class="form-control shadow-sm"
                                        placeholder="Share your thoughts about this report..." required></textarea>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                        <i class="bi bi-send-fill me-1"></i> Submit
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            @endif

            @isset($report)
                <div class="report-card bg-white p-4 rounded shadow-sm">
                    <!-- Report Meta Info - Modern Table UI -->
                    <div class="card mb-3 shadow-sm border-0">
                        <div class="card-header bg-primary text-white">
                            <i class="fa-solid fa-info-circle me-2"></i> Report Information
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="row">Type</th>
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
                                        <th scope="row">Submitted by</th>
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

                    {{-- Location Section --}}
                    <div class="location-section mb-4">
                        <h3 class="h5">Incident Location</h3>

                        @if ($report->barangay)
                            <p><strong>Barangay:</strong> {{ $report->barangay }}</p>
                        @endif

                        @if ($report->latitude && $report->longitude)
                            <p><strong>Coordinates:</strong> {{ number_format($report->latitude, 6) }},
                                {{ number_format($report->longitude, 6) }}</p>

                            {{-- Map preview --}}
                            <div id="reportMap" class="w-100 rounded-3 border bg-light" style="height: 250px;"
                                data-lat="{{ $report->latitude ?? '' }}" data-lng="{{ $report->longitude ?? '' }}">
                            </div>
                        @else
                            <p class="text-muted">No location provided.</p>
                        @endif
                    </div>

                    {{-- Attachments --}}
                    <div class="attachments-section mb-4">
                        <h3 class="h5">
                            <i class="fa-solid fa-paperclip me-1"></i> Report Images
                        </h3>

                        @if ($report->images->count())
                            <div class="attachments-grid d-flex flex-wrap gap-3">
                                @foreach ($report->images as $index => $image)
                                    <div class="attachment-item">
                                        <img src="{{ asset('storage/' . $image->file_path) }}"
                                            alt="Attachment {{ $index + 1 }}" class="thumbnail"
                                            onclick="openImageModal({{ $index }})">
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">No attachments provided.</p>
                        @endif
                    </div>

                    {{-- ... keep the rest as is ... --}}

                    {{-- Action Buttons / Status Notice --}}
                    <div class="action-section mt-3">
                        @if (
                            !in_array($report->report_status, [
                                \App\Models\IncidentReporting\IncidentReportUser::STATUS_SUCCESS,
                                \App\Models\IncidentReporting\IncidentReportUser::STATUS_CANCELED,
                            ]))
                            {{-- Buttons visible --}}
                            <div class="action-buttons d-flex gap-2">
                                <!-- Request Edit Button -->
                                <button type="button" class="btn btn-primary btn-sm btn-edit-request"
                                    data-edit-pending="{{ $report->editRequest && $report->editRequest->status === 'pending' ? 'true' : 'false' }}"
                                    data-edit-url="{{ route('user.report.edit', $report->id) }}">
                                    <i class="fa-solid fa-pen me-1"></i> Request Edit
                                </button>


                                <form method="POST" action="{{ route('user.report.delete', $report->id) }}"
                                    class="delete-request-form">
                                    @csrf
                                    @method('DELETE')
                                    <!-- hidden input that JS will fill -->
                                    <input type="hidden" name="reason" class="delete-reason">
                                    <button type="button" class="btn btn-outline-danger btn-sm btn-delete-request">
                                        <i class="fa-solid fa-trash me-1"></i> Request Delete
                                    </button>
                                </form>


                            </div>
                        @else
                            {{-- Show notice when report is success or canceled --}}
                            @php
                                $alertClass = $report->isSuccess() ? 'alert-success' : 'alert-danger';
                                $iconClass = $report->isSuccess() ? 'fa-circle-check' : 'fa-circle-xmark';
                                $statusText = $report->readableStatus(); // <-- use readableStatus()
                            @endphp
                            <div class="alert {{ $alertClass }} d-flex align-items-start shadow-sm">
                                <i class="fa-solid {{ $iconClass }} fs-4 me-2"></i>
                                <div>
                                    <strong>Report is {{ $statusText }}</strong>
                                    <p class="mb-0 mt-1">This report is <span
                                            class="text-capitalize">{{ $statusText }}</span>. Editing or deletion is no
                                        longer allowed.</p>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            @else
                <p class="text-danger">Report not found or data is missing.</p>
            @endisset

            <span id="reportStatus" class="d-none">{{ $report->report_status }}</span>

            {{-- Image Modal --}}
            <div id="imageModal" class="image-modal" role="dialog" aria-modal="true">
                <span class="close" onclick="closeModal()" aria-label="Close">&times;</span>
                <span class="prev" onclick="changeImage(-1)">&#10094;</span>
                <span class="next" onclick="changeImage(1)">&#10095;</span>
                <img id="expandedImg" class="modal-content" />
                <div id="caption" class="caption mt-2 text-white text-center"></div>
            </div>
        </main>
    </div>
    <script src="{{ asset('bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @vite('resources/js/componentsjs/navbar.js')
    @vite('resources/js/userjs/view-reports.js')
    @include('sweetalert::alert')
</body>

</html>
