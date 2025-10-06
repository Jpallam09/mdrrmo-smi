<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Staff - Deletion Requests</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon/SMI_logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon/SMI_logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    -
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.7-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite('resources/css/componentscss/navbarcss/shared-navbar.css')
    @vite('resources/css/staffcss/staff-deletion-requests.css')
</head>

<body>
    <main class="layout d-flex">
        <x-navbar.shared-navbar />

        <section class="page-content flex-grow-1 pt-5 px-4">
            <div class="container">
                <!-- Page Title -->
                <div class="row mt-4 mb-4">
                    <div class="col">
                        <h1 class="page-title">Deletion Requests</h1>
                    </div>
                </div>
                <!-- Table Section -->
                <div class="table-responsive bg-white p-3 rounded-3">
                    <table class="table table-bordered table-hover table-striped align-middle text-center report-table">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th class="text-truncate" style="max-width: 120px;">Username</th>
                                <th class="text-truncate" style="max-width: 200px;">Reason</th>
                                <th class="text-truncate" style="max-width: 180px;">Report Title</th>
                                <th class="text-truncate" style="max-width: 120px;">Date Requested</th>
                                <th>Report Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deleteRequests as $index => $request)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="text-capitalize text-truncate" style="max-width: 120px;">
                                        {{ $request->user->user_name ?? 'Unknown' }}
                                    </td>
                                    <td class="text-truncate" style="max-width: 200px;">
                                        {{ $request->reason }}
                                    </td>
                                    <td class="text-truncate" style="max-width: 180px;">
                                        {{ $request->report_title }}
                                    </td>
                                    <td class="text-truncate" style="max-width: 120px;">
                                        {{ \Carbon\Carbon::parse($request->report_date)->format('M d, Y') }}
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-{{ strtolower($request->status) === 'pending' ? 'warning' : (strtolower($request->status) === 'approved' ? 'success' : 'danger') }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </td>
                                    <td class="action-col">
                                        <div class="d-flex justify-content-center gap-2">
                                            <!-- View Button -->
                                            <a href="{{ route('staff.report.delete.show', $request->id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>

                                            <!-- Accept Button -->
                                            <form method="POST"
                                                action="{{ route('staff.report.delete.accept', $request->id) }}"
                                                class="m-0 p-0 confirm-form" data-action="accept">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fa-solid fa-circle-check"></i>
                                                </button>
                                            </form>

                                            <!-- Reject Button -->
                                            <form method="POST"
                                                action="{{ route('staff.report.delete.reject', $request->id) }}"
                                                class="m-0 p-0 confirm-form" data-action="reject">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fa-solid fa-circle-xmark"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if ($deleteRequests->isEmpty())
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-2x mb-2"></i>
                            <p class="mb-0">No deletion requests found.</p>
                        </div>
                    @endif
                </div>
                <div class="pagination row mt-4">
                    <div class="col d-flex justify-content-center">
                        {{ $deleteRequests->links('vendor.pagination.default') }}
                    </div>
                </div>
            </div>
        </section>

    </main>

    @include('sweetalert::alert')
    @vite('resources/js/staffjs/staff-deletion-request.js')
    @vite('resources/js/componentsjs/navbar.js')
    <script src="{{ asset('bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
