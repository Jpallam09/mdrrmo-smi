@props([
    'action' => '#',
    'search' => '',
    'status' => '',
    'requestFilter' => '',
    'statuses' => null,
])

@php
    use App\Models\IncidentReporting\IncidentReportUser;

    $statuses = $statuses ?? IncidentReportUser::$statuses;

    $statusLabels = [
        'pending' => 'Pending',
        'success' => 'Successful',
        'canceled' => 'Unsuccessful',
    ];

    // Unified request filter options
    $requestOptions = [
        '' => 'All Requests',
        'none' => 'No Requests',
        'edit' => 'Pending Edit Requests',
        'delete' => 'Pending Delete Requests',
    ];
@endphp

<div id="reports-table" class="mb-3 card p-3">
    {{-- Active Filters --}}
    @if ($search || $status || $requestFilter)
        <small class="text-muted mb-2 d-block">
            Filtering by:
            @foreach (['search' => $search, 'status' => $status, 'requestFilter' => $requestFilter] as $key => $value)
                @if ($value)
                    @php
                        $label = match ($key) {
                            'status' => $statusLabels[$value] ?? ucfirst($value),
                            'requestFilter' => $requestOptions[$value] ?? ucfirst($value),
                            default => $value,
                        };
                        $badgeClass = match ($key) {
                            'search' => 'bg-primary',
                            'status' => match ($value) {
                                'pending' => 'bg-warning',
                                'success' => 'bg-success',
                                'canceled' => 'bg-danger',
                            },
                            'requestFilter' => 'bg-warning',
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }}">{{ $label }}</span>
                @endif
            @endforeach
        </small>
    @endif

    {{-- Search + Filters Form --}}
    <form id="searchForm" action="{{ $action }}#reports-table" method="GET"
        class="d-flex gap-2 flex-wrap justify-content-center align-items-center">

        {{-- Search input --}}
        <input type="text" name="search" class="form-control form-control-sm rounded-pill shadow-sm w-50"
            placeholder="Search reports..." value="{{ $search }}">

        {{-- Status dropdown --}}
        <select name="status" class="form-select form-select-sm rounded-pill shadow-sm w-auto">
            <option value="">All Report Status</option>
            @foreach ($statuses as $value)
                <option value="{{ $value }}" {{ $status === $value ? 'selected' : '' }}>
                    {{ $statusLabels[$value] ?? ucfirst($value) }}
                </option>
            @endforeach
        </select>

        {{-- Request filter dropdown --}}
        <select name="requestFilter" class="form-select form-select-sm rounded-pill shadow-sm w-auto">
            @foreach ($requestOptions as $key => $label)
                <option value="{{ $key }}" {{ $requestFilter === $key ? 'selected' : '' }}>{{ $label }}
                </option>
            @endforeach
        </select>

        {{-- Action buttons --}}
        <button type="submit" class="btn btn-primary btn-sm rounded-pill px-3">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
        <a href="{{ $action }}#reports-table" id="resetButton"
            class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="fa-solid fa-rotate-left"></i>
        </a>
    </form>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const scrollToReports = () => document.getElementById('reports-table')?.scrollIntoView({
                behavior: 'smooth'
            });

            ['searchForm', 'resetButton'].forEach(id => {
                document.getElementById(id)?.addEventListener('click', () => setTimeout(scrollToReports,
                    100));
                if (id === 'searchForm') {
                    document.getElementById(id)?.addEventListener('submit', () => setTimeout(
                        scrollToReports, 100));
                }
            });
        });
    </script>
@endpush
