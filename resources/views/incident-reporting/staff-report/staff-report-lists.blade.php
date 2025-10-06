<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff - View All Reports</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon/SMI_logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon/SMI_logo.png') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.7-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    @vite('resources/css/componentscss/navbarcss/shared-navbar.css')
    @vite('resources/css/staffcss/staff-report-view.css')

</head>

<body>
    <main class="layout d-flex">
        <x-navbar.shared-navbar />

        <section class="page-content flex-grow-1 pt-5 px-4">
            <div class="container-fluid">

                <!-- Page Title -->
                <div class="row mt-4 mb-4">
                    <div class="col">
                        <h1 class="page-title">Report List table</h1>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive shadow-sm rounded bg-white p-3">
                            <x-modals.shared-search-bar :action="route('staff.report.list')" :search="request('search')" :status="request('status')"
                                :requestFilter="request('requestFilter')" :statuses="['pending', 'success', 'canceled']" />
                            <table
                                class="table table-bordered table-striped table-hover align-middle text-center report-table">
                                <thead class="table-primary">
                                    <tr>
                                        <th>#</th>
                                        <th>Username</th>
                                        <th>Report Title</th>
                                        <th>Report Type</th>
                                        <th>Date Submitted</th>
                                        <th>Report Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reports as $index => $report)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td class="text-capitalize text-truncate" style="max-width: 120px;">
                                                {{ $report->user->user_name ?? 'Unknown' }}</td>
                                            <td class="text-truncate" style="max-width: 180px;">
                                                {{ $report->report_title }}</td>
                                            <td class="text-truncate" style="max-width: 120px;">
                                                {{ $report->report_type }}</td>
                                            <td class="text-truncate" style="max-width: 120px;">
                                                {{ \Carbon\Carbon::parse($report->report_date)->format('M d, Y') }}</td>
                                            <td>
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'bg-warning',
                                                        'in_progress' => 'bg-primary',
                                                        'success' => 'bg-success',
                                                        'canceled' => 'bg-danger',
                                                    ];
                                                    $statusLabels = [
                                                        'pending' => 'Pending',
                                                        'in_progress' => 'In Progress',
                                                        'success' => 'Successful',
                                                        'canceled' => 'Unsuccessful',
                                                    ];
                                                @endphp
                                                <span
                                                    class="badge {{ $statusColors[$report->report_status] ?? 'bg-secondary' }}">
                                                    {{ $statusLabels[$report->report_status] ?? ucfirst(str_replace('_', ' ', $report->report_status)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1 justify-content-center">
                                                    <a href="{{ route('staff.report.view', $report->id) }}"
                                                        class="btn btn-sm btn-primary text-truncate">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                    <a href="{{ route('staff.report.exportPdf', $report->id) }}"
                                                        class="btn btn-sm btn-outline-danger text-truncate">
                                                        <i class="fa-solid fa-file-pdf"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            @if ($reports->isEmpty())
                                <div class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2"></i>
                                    <p class="mb-0">No reports found.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="pagination row mt-4">
                    <div class="col d-flex justify-content-center">
                        {{ $reports->links('vendor.pagination.default') }}
                    </div>
                </div>

            </div>
        </section>
    </main>

    @include('sweetalert::alert')
    @vite('resources/js/componentsjs/navbar.js')
    <script src="{{ asset('bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
