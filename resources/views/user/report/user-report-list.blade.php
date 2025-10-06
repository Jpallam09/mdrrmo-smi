        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1" />
            <title>Report Lists</title>
            <link rel="icon" type="image/png" href="{{ asset('favicon/SMI_logo.png') }}">
            <link rel="shortcut icon" href="{{ asset('favicon/SMI_logo.png') }}">

            {{-- Bootstrap and Icons --}}
            <link rel="stylesheet" href="{{ asset('bootstrap-5.3.7-dist/css/bootstrap.min.css') }}">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

            <!-- SweetAlert2 -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            {{-- Vite Assets --}}
            @vite('resources/css/componentscss/navbarcss/shared-navbar.css')
            @vite('resources/css/usercss/user-dashboard-reporting.css')

        </head>

        <body>
            {{-- Navbar --}}
            <main class="layout d-flex">
                <x-navbar.user-navbar />

                <section class="page-content flex-grow-1 pt-5 px-4">
                    <div class="container-fluid">
                        {{-- Hero Section --}}
                        <div class="row mb-4">
                            <div class="col">
                                <h2 id="dashboard-title" class="mb-1">Your report summaries</h2>
                            </div>
                        </div>

                        <!-- Widgets Row -->
                        <div class="row g-3 widgets">
                            <!-- Top row (3 widgets) -->
                            <div class="col-md-4">
                                <section class="widget" id="totalReportsWidget">
                                    <a class="widget-link">
                                        <h2><i class="fas fa-file-alt"></i> Total reports</h2>
                                        <p class="text-start fw-light small text-muted mb-0">Your total report counts
                                        </p>
                                        <p class="count">{{ $totalReports }}</p>
                                    </a>
                                </section>
                            </div>
                            <div class="col-md-4">
                                <section class="widget" id="openReportsWidget">
                                    <a class="widget-link">
                                        <h2><i class="fas fa-envelope-open-text"></i> Unresponded reports</h2>
                                        <p class="text-start fw-light small text-muted mb-0">Your total pending report
                                            counts</p>
                                        <p class="count">{{ $pendingReports }}</p>
                                    </a>
                                </section>
                            </div>
                            <div class="col-md-4">
                                <section class="widget" id="resolvedReportsWidget">
                                    <a class="widget-link">
                                        <h2><i class="fas fa-check-circle"></i> Successful reports</h2>
                                        <p class="text-start fw-light small text-muted mb-0">Your total resolved report
                                            counts</p>
                                        <p class="count">{{ $successReports }}</p>
                                    </a>
                                </section>
                            </div>

                            <!-- Bottom row (3 widgets) -->
                            <div class="col-md-4">
                                <section class="widget" id="cancelRequestsWidget">
                                    <a class="widget-link">
                                        <h2><i class="fas fa-ban"></i> Unsuccessful reports </h2>
                                        <p class="text-start fw-light small text-muted mb-0">Reports that failed to be
                                            resolved</p>
                                        <p class="count">{{ $canceledReports }}</p>
                                    </a>
                                </section>
                            </div>
                            <div class="col-md-4">
                                <section class="widget" id="editRequestsWidget">
                                    <a class="widget-link">
                                        <h2><i class="fas fa-edit"></i>Pending edit requests</h2>
                                        <p class="text-start fw-light small text-muted mb-0">Your total edit requests
                                            report
                                            counts</p>
                                        <p class="count">{{ $editRequest }}</p>
                                    </a>
                                </section>
                            </div>
                            <div class="col-md-4 mb-4">
                                <section class="widget" id="deleteRequestsWidget">
                                    <a class="widget-link">
                                        <h2><i class="fas fa-trash-alt"></i>Pending delete requests</h2>
                                        <p class="text-start fw-light small text-muted mb-0">Your total delete requests
                                            report counts</p>
                                        <p class="count">{{ $deleteRequest }}</p>
                                    </a>
                                </section>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col">
                                <h2 id="dashboard-title" class="mb-2">Your Report Lists</h2>
                            </div>
                        </div>

                        {{-- Reports Table --}}
                        <div class="row mt-2" id="reports-table">
                            <div class="col-12">
                                <div class="table-responsive shadow-sm rounded bg-white p-1">
                                    <x-modals.shared-search-bar :action="route('user.report.home')" :search="$search ?? ''" :status="$status ?? ''"
                                        :requestFilter="$requestFilter ?? ''" :statuses="['success', 'canceled']" />

                                    <table
                                        class="table table-bordered table-striped table-hover text-center align-middle report-table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>#</th>
                                                <th>Title</th>
                                                <th>Date</th>
                                                <th>Type</th>
                                                <th>Report Status</th>
                                                <th>Edit/Delete Requests</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($reports as $index => $report)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $report->report_title }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($report->report_date)->format('F d, Y') }}
                                                    </td>
                                                    <td>{{ $report->report_type }}</td>
                                                    <td>
                                                        @php
                                                            $statusColors = [
                                                                'pending' => 'bg-warning',
                                                                'in_progress' => 'bg-primary',
                                                                'success' => 'bg-success',
                                                                'canceled' => 'bg-danger',
                                                            ];

                                                            // Map the label text
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

                                                    <td class="request-status">
                                                        @if ($report->editRequest)
                                                            <span
                                                                class="badge
                                                                {{ $report->editRequest->status === 'pending'
                                                                    ? 'bg-warning'
                                                                    : ($report->editRequest->status === 'approved'
                                                                        ? 'bg-success'
                                                                        : 'bg-danger') }}">
                                                                Edit Request
                                                                {{ ucfirst($report->editRequest->status) }}
                                                            </span>
                                                        @elseif ($report->deleteRequest)
                                                            <span
                                                                class="badge
                                                        {{ $report->deleteRequest->status === 'pending'
                                                            ? 'bg-warning'
                                                            : ($report->deleteRequest->status === 'approved' || $report->deleteRequest->status === 'accepted'
                                                                ? 'bg-success'
                                                                : 'bg-danger') }}">
                                                                Delete Request
                                                                {{ ucfirst($report->deleteRequest->status) }}
                                                            </span>
                                                        @else
                                                            <span class="badge bg-secondary">None</span>
                                                        @endif
                                                    </td>

                                                    <td class="text-center">
                                                        <div class="d-flex gap-1 justify-content-center">
                                                            {{-- View --}}
                                                            <a href="{{ route('user.report.view', $report->id) }}"
                                                                class="btn btn-sm btn-primary d-inline-flex align-items-center">
                                                                <i class="fas fa-eye"></i>
                                                            </a>

                                                            {{-- Edit --}}
                                                            <button type="button"
                                                                class="btn btn-warning btn-sm text-white btn-edit-request"
                                                                data-edit-pending="{{ $report->editRequest && $report->editRequest->status === 'pending' ? 'true' : 'false' }}"
                                                                data-edit-url="{{ route('user.report.edit', $report->id) }}">
                                                                <i class="fa-solid fa-pen"></i>
                                                            </button>

                                                            {{-- Delete --}}
                                                            <form method="POST"
                                                                action="{{ route('user.report.delete', $report->id) }}"
                                                                class="delete-request-form d-inline"
                                                                data-delete-pending="{{ $report->deleteRequest && $report->deleteRequest->status === 'pending' ? 'true' : 'false' }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="hidden" name="reason"
                                                                    class="delete-reason">
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm btn-delete-request">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    @if ($reports->isEmpty())
                                        <div class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-2x mb-2"></i>
                                            <p class="mb-0">No incident reports found.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Pagination --}}
                        <div class="row mt-4">
                            <div class="col d-flex justify-content-center">
                                {{ $reports->withQueryString()->fragment('reports-table')->links('vendor.pagination.default') }}
                            </div>
                        </div>
                    </div>
                </section>
            </main>

            @include('sweetalert::alert')
            @vite('resources/js/componentsjs/navbar.js')
            @vite('resources/js/userjs/view-reports.js')
            {{-- Bootstrap JS (Optional) --}}
            <script src="{{ asset('bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js') }}"></script>
            @stack('scripts')
        </body>

        </html>
