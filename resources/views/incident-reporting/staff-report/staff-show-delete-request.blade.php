<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Request Details</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon/SMI_logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon/SMI_logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite('resources/css/componentscss/navbarcss/shared-navbar.css')
</head>

<body class="bg-light">
    <main class="layout d-flex">
        <x-navbar.shared-navbar />

        <div class="page-content flex-grow-1 container py-5 mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                <h4 class="mb-0 text-danger">
                    <i class="fa fa-trash me-2"></i> Delete Request Details
                    <small class="text-muted d-block mt-3" style="font-size: 1.2rem;">
                        Submitted by: <strong>{{ $request->user->user_name }}</strong>
                    </small>
                </h4>
                <a href="{{ route('staff.report.delete.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left me-1"></i> Back to Delete Requests table
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

            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-danger text-white">
                    <i class="fa-solid fa-info-circle me-2"></i> Report Information
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <tbody>
                            <tr>
                                <th scope="row" class="w-25">Title</th>
                                <td>{{ $request->report->report_title }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Phone number</th>
                                <td>{{ $request->user->phone ?? 'Unknown' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Date</th>
                                <td>{{ \Carbon\Carbon::parse($request->created_at)->format('M d, Y') }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Type</th>
                                <td>{{ $request->report->report_type }}</td>
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
                    <p class="mb-0">{{ $request->report->report_description }}</p>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header fw-bold">Location</div>
                <div class="card-body">
                    @if (!empty($request->report->latitude) && !empty($request->report->longitude))
                        <div id="reportMap" class="w-100 rounded border" style="height: 200px;"
                            data-lat="{{ $request->report->latitude }}" data-lng="{{ $request->report->longitude }}">
                        </div>
                    @else
                        <div class="d-flex flex-column align-items-center justify-content-center text-muted border rounded"
                            style="height: 200px;">
                            <i class="fa-solid fa-map-location-dot fa-2x mb-2"></i>
                            <span>No location provided</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="attachments-section mb-4">
                <h3 class="h5 mb-3">
                    <i class="fa-solid fa-paperclip me-1"></i> Report Images
                </h3>

                @if ($request->report && $request->report->images->count())
                    <div class="row g-3">
                        @foreach ($request->report->images as $index => $image)
                            <div class="col-6 col-md-3">
                                <div class="card shadow-sm h-100">
                                    <img src="{{ asset('storage/' . $image->file_path) }}"
                                        alt="Attachment {{ $index + 1 }}" class="card-img-top img-fluid rounded"
                                        style="width: 100%; height: 150px; object-fit: cover;">
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-secondary text-center py-4 rounded shadow-sm">
                        <i class="fa-solid fa-file-circle-xmark fa-2x mb-2 text-muted"></i>
                        <p class="mb-0">No attachments provided</p>
                    </div>
                @endif
            </div>

            <div class="d-flex justify-content-end gap-2 mb-5">
                @if ($request->status !== 'rejected')
                    <form method="POST"
                        action="{{ route('staff.report.delete.accept', $request->id) }}"
                        class="confirm-form" data-action="accept">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fa fa-check me-1"></i> Accept
                        </button>
                    </form>

                    <form method="POST"
                        action="{{ route('staff.report.delete.reject', $request->id) }}"
                        class="confirm-form" data-action="reject">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="fa fa-times me-1"></i> Reject
                        </button>
                    </form>
                @else
                    <div class="alert alert-danger w-100" role="alert">
                        Request rejected
                    </div>
                @endif
            </div>

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    @vite('resources/js/componentsjs/navbar.js')
    @vite('resources/js/staffjs/staff-deletion-request.js')
    @vite('resources/js/componentsjs/map.js')
    @include('sweetalert::alert')
</body>

</html>
