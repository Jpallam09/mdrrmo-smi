    <!-- Navbar -->
    <nav class="navbar d-flex justify-content-end align-items-center px-4 shadow-sm bg-white">
        <ul class="navbar__menu d-flex align-items-center gap-3 mb-0 list-unstyled">
            <!-- User info -->
            <li class="d-flex align-items-center gap-2">
                <span class="d-none d-md-inline">{{ auth()->user()->user_name }}</span>
                <img src="{{ Auth::user()?->profile_picture
                    ? asset('storage/profile_pictures/' . Auth::user()->profile_picture)
                    : asset('images/pfp.png') }}"
                    class="rounded-circle" width="32" height="32" alt="Staff Avatar">
            </li>

            <!-- Notification Dropdown -->
            <li class="nav-item dropdown position-relative">
                <a class="nav-link position-relative" href="#" id="notificationDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false" aria-label="Notifications">
                    <i class="fas fa-bell fa-lg"></i>
                    @if (isset($unreadNotifications) && $unreadNotifications->count() > 0)
                        <span
                            class="badge bg-danger rounded-circle position-absolute top-0 start-100 translate-middle p-1">
                            {{ $unreadNotifications->count() }}
                        </span>
                    @endif
                </a>

                <ul class="dropdown-menu dropdown-menu-end p-2"
                    style="max-height: 400px; overflow-y: auto; min-width: 350px;"
                    aria-labelledby="notificationDropdown">

                    @if (!isset($notifications) || $notifications->isEmpty())
                        <li class="dropdown-item text-center text-muted small py-3">
                            <i class="fas fa-info-circle me-1"></i> No new notifications
                        </li>
                    @else
                        @foreach ($notifications as $index => $notification)
                            @php
                                // Determine icon and color based on notification type
                                $iconClass = 'fas fa-info-circle text-secondary';

                                if (isset($notification->data['report_id']) && !isset($notification->data['comment'])) {
                                    $iconClass = 'fas fa-file-alt text-primary'; // New report
                                } elseif (
                                    isset($notification->data['report_id']) &&
                                    isset($notification->data['comment'])
                                ) {
                                    $iconClass = 'fas fa-comment-dots text-success'; // Feedback
                                } elseif (isset($notification->data['edit_request_id'])) {
                                    $iconClass = 'fas fa-pencil-alt text-warning'; // Edit request
                                } elseif (isset($notification->data['delete_request_id'])) {
                                    $iconClass = 'fas fa-trash-alt text-danger'; // Delete request
                                }

                                // Background for unread vs read
                                if (is_null($notification->read_at)) {
                                    $bgClass = 'bg-primary bg-opacity-10'; // Highlight gray for unread
                                    $textClass = 'fw-bold text-dark'; // Bold for unread
                                } else {
                                    // Zebra stripe for read notifications
                                    $bgClass = $index % 2 === 0 ? 'bg-white' : 'bg-light';
                                    $textClass = 'text-muted';
                                }
                            @endphp

                            <li>
                                <a href="{{ route('staff.report.notifications.markRead', $notification->id) }}"
                                    class="dropdown-item d-flex align-items-start gap-2 p-2 mb-1 rounded {{ $bgClass }} {{ $textClass }}">
                                    <i class="{{ $iconClass }} mt-1 fs-6"></i>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <strong>{{ $notification->data['title'] ?? 'User Feedback' }}</strong>
                                            <small
                                                class="text-muted ms-2">{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                        <small class="d-block mt-1">
                                            <strong>User:</strong>
                                            {{ $notification->data['user_name'] ?? ($notification->data['submitted_by'] ?? 'Unknown') }}
                                        </small>
                                        <small class="d-block text-truncate mt-1" style="max-width: 260px;">
                                            {{ \Illuminate\Support\Str::limit($notification->data['comment'] ?? ($notification->data['message'] ?? ''), 60) }}
                                        </small>
                                    </div>
                                </a>
                            </li>

                            @if ($index !== $notifications->count() - 1)
                                <hr class="my-1 mx-2" />
                            @endif
                        @endforeach
                    @endif
                </ul>
            </li>

            <!-- Settings Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="settingsDropdown" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false" aria-label="Settings">
                    <i class="fas fa-cog"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="settingsDropdown">
                    <li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center gap-2">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </li>
                    <li>
                        <a href="{{ route('staff.report.profile.show') }}"
                            class="dropdown-item d-flex align-items-center gap-2">
                            <i class="fas fa-user-circle"></i> Profile
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Layout -->
    <div class="layout">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar py-3 px-2">
            <!-- Brand -->
            <div class="d-flex align-items-center gap-2 px-3 mb-4">
                <img src="{{ asset('images/SMI_logo.png') }}" alt="Logo" class="img-fluid" width="40"
                    height="40">

                <div class="d-flex flex-column lh-1">
                    <span class="text-uppercase text-white"
                        style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 0.9rem; letter-spacing: 0.5px;">
                        Incident
                    </span>
                    <span class="text-uppercase text-white"
                        style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.4rem; letter-spacing: 1px;">
                        Reporting
                    </span>
                </div>
            </div>

            <ul class="sidebar__nav d-flex flex-column gap-2 mb-0 list-unstyled">
                <hr class="m-0">
                <li class="sidebar__item">
                    <a href="{{ route('staff.report.dashboard') }}"
                        class="sidebar__link {{ request()->routeIs('staff.report.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-line me-2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <hr class="m-0">
                <li class="sidebar__item">
                    <a href="{{ route('staff.report.list') }}"
                        class="sidebar__link {{ request()->routeIs('staff.report.list') ? 'active' : '' }}">
                        <i class="fas fa-file-alt me-2"></i>
                        <span>Reports List</span>
                    </a>
                </li>
                <li class="sidebar__item">
                    <a href="{{ route('staff.report.delete.index') }}"
                        class="sidebar__link {{ request()->routeIs('staff.report.delete.index') ? 'active' : '' }}">
                        <i class="fas fa-trash-alt me-2"></i>
                        <span>Delete Requests</span>
                    </a>
                </li>
                <li class="sidebar__item">
                    <a href="{{ route('staff.report.edit.index') }}"
                        class="sidebar__link {{ request()->routeIs('reporting.staff.edit.index') ? 'active' : '' }}">
                        <i class="fas fa-edit me-2"></i>
                        <span>Edit Requests</span>
                    </a>
                </li>
            </ul>
        </aside>
        <!-- Bottom Navbar (Mobile Only) -->
        <nav class="bottom-nav d-lg-none fixed-bottom bg-white border-top shadow-sm">
            <ul class="bottom-nav__menu d-flex justify-content-around m-0 p-0 list-unstyled">
                <li>
                    <a href="{{ route('staff.report.dashboard') }}"
                        class="bottom-nav__link {{ request()->routeIs('staff.report.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.report.list') }}"
                        class="bottom-nav__link {{ request()->routeIs('staff.report.list') ? 'active' : '' }}">
                        <i class="fas fa-file-alt"></i>
                        <span>Reports</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.report.delete.index') }}"
                        class="bottom-nav__link {{ request()->routeIs('staff.report.delete.index') ? 'active' : '' }}">
                        <i class="fas fa-trash-alt"></i>
                        <span>Delete</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.report.edit.index') }}"
                        class="bottom-nav__link {{ request()->routeIs('staff.report.edit.index') ? 'active' : '' }}">
                        <i class="fas fa-edit"></i>
                        <span>Edit</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
