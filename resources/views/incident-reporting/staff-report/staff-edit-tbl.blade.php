<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff - Update Requests</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon/SMI_logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon/SMI_logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.7-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    @vite('resources/css/componentscss/navbarcss/shared-navbar.css')
    @vite('resources/css/staffcss/staff-update-requests.css')
    @vite('resources/css/componentscss/modalcss/view-request-modal.css')
</head>

<body>
    <main class="layout d-flex">
        <x-navbar.shared-navbar />

        <section class="page-content flex-grow-1 pt-5 px-4">
            <div class="container-fluid">

                <div class="row mt-4 mb-4">
                    <div class="col">
                        <h1 class="page-title">Edit Requests</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive shadow-sm rounded bg-white p-3">
                            <table
                                class="table table-bordered table-striped table-hover align-middle text-center report-table">
                                <thead class="table-primary">
                                    <tr>
                                        <th>#</th>
                                        <th>Username</th>
                                        <th>Reason</th>
                                        <th>Original Title</th>
                                        <th>Requested Title</th>
                                        <th>Requested Description</th>
                                        <th>Report status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($requests as $index => $request)
                                        <tr class="align-middle">
                                            <td>{{ $index + 1 }}</td>
                                            <td class="text-capitalize text-truncate" style="max-width: 120px;">
                                                {{ $request->user->user_name ?? 'Unknown' }}
                                            </td>
                                            <td class="text-truncate" style="max-width: 200px;">
                                                {{ $request->reason ?? '—' }}
                                            </td>
                                            <td class="text-truncate" style="max-width: 150px;">
                                                {{ $request->report->report_title ?? 'No Title' }}
                                            </td>
                                            <td class="text-truncate" style="max-width: 150px;">
                                                {{ $request->requested_title ?? '—' }}
                                            </td>
                                            <td class="text-truncate" style="max-width: 200px;">
                                                {{ $request->requested_description ?? '—' }}
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ strtolower($request->status) === 'pending' ? 'warning' : (strtolower($request->status) === 'approved' ? 'success' : 'danger') }}">
                                                    {{ ucfirst($request->status) }}
                                                </span>
                                            </td>

                                            <td class="action-col text-center" style="width: 140px;">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <!-- View Button -->
                                                    <a href="{{ route('staff.report.edit.show', $request->id) }}"
                                                        class="btn btn-sm btn-primary" title="View Request">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <!-- Accept Button -->
                                                    <form
                                                        action="{{ route('staff.report.edit.accept', $request->id) }}"
                                                        method="POST" class="m-0 p-0 confirm-form">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-sm"
                                                            title="Accept Request">
                                                            <i class="fas fa-check-circle"></i>
                                                        </button>
                                                    </form>

                                                    <!-- Reject Button -->
                                                    <form
                                                        action="{{ route('staff.report.edit.reject', $request->id) }}"
                                                        method="POST" class="m-0 p-0 confirm-form">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            title="Reject Request">
                                                            <i class="fas fa-times-circle"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if ($requests->isEmpty())
                                <div class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2"></i>
                                    <p class="mb-0">No edit requests found.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="pagination row mt-4">
                    <div class="col d-flex justify-content-center">
                        <div class="pagination-wrapper">
                            {{ $requests->links('vendor.pagination.default') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('sweetalert::alert')
    @vite('resources/js/staffjs/staff-update-requests.js')
    @vite('resources/js/staffjs/staff-show-edit-request.js')
    @vite('resources/js/componentsjs/navbar.js')
    <script src="{{ asset('bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
