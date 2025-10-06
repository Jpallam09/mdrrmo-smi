<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Request Details</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon/SMI_logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon/SMI_logo.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    @vite('resources/css/componentscss/navbarcss/shared-navbar.css')

</head>

<body>
    <div class="layout d-flex">
        <x-navbar.shared-navbar />

        <div class="page-content flex-grow-1 pt-5 px-4 mt-4">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-2 text-primary">
                        <i class="fa-solid fa-pen-to-square me-2"></i>
                        Review Edit Request
                        <small class="text-muted d-block mt-3" style="font-size: 1.2rem;">
                            Submitted by: <strong>{{ $request->user->user_name }}</strong>
                        </small>
                    </h4>
                    <a href="{{ route('staff.report.edit.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-2"></i> Back to Edit Requests table
                    </a>
                </div>

                <div class="card mb-3 shadow-sm border-0">
                    <div class="card-header bg-warning text-dark">
                        <i class="fa-solid fa-circle-info me-2"></i> Reason for Edit Request
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $request->reason ?? '—' }}</p>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Original Report -->
                    <div class="col-md-6">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <div class="card mb-3 shadow-sm border-0">
                                    <div class="card-header bg-primary text-white">
                                        <i class="fa-solid fa-file-lines me-2"></i> Original Report
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table table-striped mb-0">
                                            <tbody>
                                                <tr>
                                                    <th scope="row" class="w-25">Title</th>
                                                    <td>{{ $request->report->report_title }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="w-25">Phone number</th>
                                                    <td>{{ $report->user->phone ?? 'Unknown' }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Date</th>
                                                    <td>{{ \Carbon\Carbon::parse($request->report->report_date)->format('M d, Y') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Type</th>
                                                    <td>{{ $request->report->report_type }}</td>
                                                </tr>
                                                <tr>
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
                                        <p class="mb-0">{{ $request->report->report_description }}</p>
                                    </div>
                                </div>
                                <!-- Original Report Location -->
                                <p><strong>Original Location:</strong></p>
                                @if (!empty($request->report->latitude) && !empty($request->report->longitude))
                                    <div id="originalMap" class="w-100 mb-3 border rounded" style="height:250px;"></div>
                                @else
                                    <div class="border rounded d-flex flex-column align-items-center justify-content-center text-muted mb-3"
                                        style="height:250px;">
                                        <i class="fa-solid fa-map-location-dot fa-2x mb-2"></i>
                                        <span>No location provided</span>
                                    </div>
                                @endif
                                <!-- Original Report Images -->
                                <p><strong>Images:</strong></p>
                                <div class="d-flex flex-wrap gap-2">
                                    <!-- Original Report Images -->
                                </div>
                                @if ($report->images && $report->images->count() > 0)
                                    @foreach ($report->images as $img)
                                        <img src="{{ asset('storage/' . $img->file_path) }}" alt="Original Image"
                                            class="img-thumbnail me-2 mb-2" style="max-width:150px;">
                                    @endforeach
                                @else
                                    <p class="text-muted">No images attached.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <div class="card mb-3 shadow-sm border-0">
                                    <div class="card-header bg-danger text-white">
                                        <i class="fa-solid fa-pen-to-square me-2"></i> Requested Changes
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table table-striped mb-0">
                                            <tbody>
                                                <tr>
                                                    <th scope="row" class="w-25">Title</th>
                                                    <td>{{ $request->requested_title ?? '—' }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Phone number</th>
                                                    <td>{{ $report->user->phone ?? 'Unknown' }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Date</th>
                                                    <td>{{ $request->requested_report_date ? \Carbon\Carbon::parse($request->requested_report_date)->format('M d, Y') : '—' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Type</th>
                                                    <td>{{ $request->requested_type ?? '—' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card mb-3 shadow-sm border-0">
                                    <div class="card-header bg-secondary text-white">
                                        <i class="fa-solid fa-align-left me-2"></i> Description
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-0">{{ $request->requested_description ?? '—' }}</p>
                                    </div>
                                </div>
                                <p><strong>Edit Request Location:</strong></p>
                                @if (!empty($request->requested_latitude) && !empty($request->requested_longitude))
                                    <div id="requestedMap" class="w-100 mb-3 border rounded" style="height:250px;">
                                    </div>
                                @elseif(!empty($request->report->latitude) && !empty($request->report->longitude))
                                    <div class="border rounded d-flex flex-column align-items-center justify-content-center text-muted mb-3"
                                        style="height:250px;">
                                        <i class="fa-solid fa-map-location-dot fa-2x mb-2"></i>
                                        <span>No location change requested</span>
                                    </div>
                                @else
                                    <div class="border rounded d-flex flex-column align-items-center justify-content-center text-muted mb-3"
                                        style="height:250px;">
                                        <i class="fa-solid fa-map-location-dot fa-2x mb-2"></i>
                                        <span>No location available</span>
                                    </div>
                                @endif
                                <!-- Requested Images -->
                                <p><strong>Edit Request Images:</strong></p>
                                <div class="d-flex flex-wrap gap-2">
                                    @if (!empty($request->requested_image) && is_array($request->requested_image))
                                        @foreach ($request->requested_image as $img)
                                            <img src="{{ asset('storage/' . $img) }}" alt="Requested Image"
                                                class="img-thumbnail me-2 mb-2" style="max-width:150px;">
                                        @endforeach
                                    @else
                                        <p class="text-muted">No requested images.</p>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($request->status === 'pending')
                    <div class="mt-4 d-flex gap-2 justify-content-end">
                        <!-- Accept Form -->
                        <form action="{{ route('staff.report.edit.accept', $request->id) }}" method="POST"
                            class="confirm-form">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fa-solid fa-check me-1"></i> Accept
                            </button>
                        </form>

                        <!-- Reject Form -->
                        <form action="{{ route('staff.report.edit.reject', $request->id) }}" method="POST"
                            class="confirm-form">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="fa-solid fa-xmark me-1"></i> Reject
                            </button>
                        </form>
                    </div>
                @else
                    <div class="alert alert-{{ $request->status === 'rejected' ? 'danger' : 'success' }} mt-4"
                        role="alert">
                        Edit Request {{ ucfirst($request->status) }}
                    </div>
                @endif

            </div>
        </div>
    </div>
    @include('sweetalert::alert')
    @vite('resources/js/staffjs/staff-show-edit-request.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.reportData = {
            originalLat: @json($request->report->latitude),
            originalLng: @json($request->report->longitude),
            requestedLat: @json($request->requested_latitude),
            requestedLng: @json($request->requested_longitude),
        };
    </script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</body>

</html>
