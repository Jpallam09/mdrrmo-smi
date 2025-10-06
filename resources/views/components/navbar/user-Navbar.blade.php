<!-- Navbar (Icons only, aligned right) -->
<nav class="navbar d-flex justify-content-end align-items-center px-4 shadow-sm">
    <ul class="navbar__menu d-flex align-items-center gap-3 mb-0 list-unstyled">

        <ul class="navbar__menu d-flex align-items-center gap-3 mb-0 list-unstyled">
            <!-- User info -->
            <li class="d-flex align-items-center gap-2">
                <span class="d-none d-md-inline">{{ auth()->user()->user_name }}</span>
                <img src="{{ Auth::user()?->profile_picture
                    ? asset('storage/profile_pictures/' . Auth::user()->profile_picture)
                    : asset('images/pfp.png') }}"
                    class="rounded-circle" width="32" height="32" alt="User Avatar">
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
                            <i class="fas fa-info-circle me-1"></i> No notifications
                        </li>
                    @else
                        @foreach ($notifications as $index => $notification)
                            @php
                                // Icon & color
                                $iconClass = 'fas fa-info-circle text-secondary';
                                if (isset($notification->data['report_id']) && !isset($notification->data['comment'])) {
                                    $iconClass = 'fas fa-file-alt text-primary'; // Report
                                } elseif (isset($notification->data['comment'])) {
                                    $iconClass = 'fas fa-comment-dots text-success'; // Feedback
                                } elseif (isset($notification->data['edit_request_id'])) {
                                    $iconClass = 'fas fa-pencil-alt text-warning'; // Edit
                                } elseif (isset($notification->data['delete_request_id'])) {
                                    $iconClass = 'fas fa-trash-alt text-danger'; // Delete
                                }

                                // Report status (if exists)
                                $statusText = null;
                                if (isset($notification->data['report_status'])) {
                                    $reportModel = new \App\Models\IncidentReporting\IncidentReportUser([
                                        'report_status' => $notification->data['report_status'],
                                    ]);
                                    $statusText = $reportModel->readableStatus();
                                }

                                // Read / unread style
                                if (is_null($notification->read_at)) {
                                    $bgClass = 'bg-primary bg-opacity-10';
                                    $textClass = 'fw-bold text-dark';
                                } else {
                                    $bgClass = $index % 2 === 0 ? 'bg-white' : 'bg-light';
                                    $textClass = 'text-muted';
                                }
                            @endphp

                            <li>
                                <a href="{{ route('user.report.notifications.markRead', $notification->id) }}"
                                    class="dropdown-item d-flex align-items-start gap-2 p-2 mb-1 rounded {{ $bgClass }} {{ $textClass }}">
                                    <i class="{{ $iconClass }} mt-1 fs-6"></i>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <strong>{{ $notification->data['title'] ?? 'Notification' }}</strong>
                                            <small
                                                class="text-muted ms-2">{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                        <small class="d-block mt-1">
                                            <strong>MDRRMO-San Mateo, Isabela</strong>
                                        </small>
                                        @if ($statusText)
                                            <small class="d-block mt-1 fw-semibold">
                                                Status: {{ $statusText }}
                                            </small>
                                        @endif
                                        <small class="d-block text-truncate mt-1" style="max-width: 260px;">
                                            {{ \Illuminate\Support\Str::limit($notification->data['message'] ?? '', 60) }}
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
            <li class="navbar__item dropdown">
                <details>
                    <summary class="dropdown__toggle" aria-haspopup="true" aria-label="Settings"> <i
                            class="fas fa-cog"></i>
                    </summary>
                    <ul class="dropdown__menu" role="menu">
                        <li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"> @csrf <button
                                    type="submit" class="dropdown__item"> <i class="fas fa-sign-out-alt"></i> Logout
                                </button> </form>
                        </li>
                        <li>
                            <a href="{{ route('user.report.profile.show') }}" class="dropdown__item">
                                <i class="fas fa-user-circle"></i> Profile
                            </a>
                        </li>
                    </ul>
                </details>
            </li>
        </ul>
</nav>

<!-- Layout Container -->
<div class="layout">
    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar py-3 px-2 d-flex flex-column">
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

        <!-- Navigation -->
        <ul class="sidebar__nav d-flex flex-column gap-2 mb-0 list-unstyled">
            <hr class="m-0">
            <li class="sidebar__item">
                <a href="{{ route('user.report.home') }}"
                    class="sidebar__link {{ request()->routeIs('user.report.home') ? 'active' : '' }}">
                    <i class="fas fa-home me-2"></i>
                    <span>Home</span>
                </a>
            </li>
            <hr class="m-0">
            <li class="sidebar__item">
                <a href="{{ route('user.report.list') }}"
                    class="sidebar__link {{ request()->routeIs('user.report.list') ? 'active' : '' }}">
                    <i class="fas fa-file-alt me-2"></i>
                    <span>My reports List</span>
                </a>
            </li>
            <li class="sidebar__item">
                <a href="{{ route('user.report.create') }}"
                    class="sidebar__link {{ request()->routeIs('user.report.create') ? 'active' : '' }}">
                    <i class="fas fa-edit me-2"></i>
                    <span>Create Report</span>
                </a>
            </li>
        </ul>

        <!-- FAQ (Pinned at bottom) -->
        <ul class="sidebar__nav d-flex flex-column gap-2 mt-auto list-unstyled">
            <li class="sidebar__item">
                <a href="{{ route('user.report.home') }}#faq" class="sidebar__link">
                    <i class="fas fa-question-circle me-2"></i>
                    <span>FAQ</span>
                </a>
            </li>
        </ul>
    </aside>

<nav class="bottom-nav d-lg-none">
    <ul class="bottom-nav__menu">
        <li>
            <a href="{{ route('user.report.home') }}"
               class="bottom-nav__link {{ request()->routeIs('user.report.home*') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
        </li>
        <li>
            <a href="{{ route('user.report.list') }}"
               class="bottom-nav__link {{ request()->routeIs('user.report.list*') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i>
                <span>Reports</span>
            </a>
        </li>
        <li>
            <a href="{{ route('user.report.create') }}"
               class="bottom-nav__link {{ request()->routeIs('user.report.create*') ? 'active' : '' }}">
                <i class="fas fa-edit"></i>
                <span>Create</span>
            </a>
        </li>
        <li>
            <a href="{{ route('user.report.home', ['#faq']) }}"
               class="bottom-nav__link {{ request()->is('home#faq') ? 'active' : '' }}">
                <i class="fas fa-question-circle"></i>
                <span>FAQ</span>
            </a>
        </li>
    </ul>
</nav>

</div>
