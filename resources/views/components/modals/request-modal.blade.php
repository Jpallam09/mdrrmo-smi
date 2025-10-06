<!-- Modal -->
<div class="edit-request-modal" id="viewEditRequestModal-{{ $request->id }}">
    <div class="edit-request-dialog">
        <div class="edit-request-content">
            <!-- Header -->
            <div class="edit-request-header">
                <h5 class="edit-request-title">Review Edit Request (Report ID: {{ $request->incident_report_id }})</h5>
                <button type="button" class="edit-request-close" aria-label="Close">×</button>
            </div>

            <!-- Body -->
            <div class="edit-request-body">
                <div class="edit-request-columns">
                    <!-- Original Report -->
                    <div class="edit-original-report">
                        <h6 class="edit-section-title text-primary">Original Report</h6>
                        <div><strong>Title:</strong> {{ $report->title }}</div>
                        <div><strong>Date:</strong>
                            {{ \Carbon\Carbon::parse($report->incident_date)->format('F d, Y') }}</div>
                        <div><strong>Type:</strong> {{ $report->incident_type }}</div>
                        <div><strong>Description:</strong><br>{{ $report->report_description }}</div>
                        <div class="edit-images-label"><strong>Images:</strong></div>
                        <div class="edit-request-attachments">
                            @if ($report->images->count())
                                @foreach ($report->images as $index => $image)
                                    <div>
                                        <img src="{{ asset('storage/' . $image->file_path) }}"
                                            alt="Attachment {{ $index + 1 }}" class="edit-thumbnail"
                                            onclick="openImageModal({{ $index }})">
                                    </div>
                                @endforeach
                            @else
                                <p class="text-light">No attachments provided.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Requested Changes -->
                    <div class="edit-requested-report">
                        <h6 class="edit-section-title text-danger">Requested Changes</h6>
                        <div><strong>Title:</strong> {{ $request->requested_title ?? '—' }}</div>
                        <div><strong>Date:</strong>
                            @if (old('incident_date'))
                                {{ \Carbon\Carbon::parse(old('incident_date'))->format('F d, Y') }}
                            @endif
                        </div>
                        <div><strong>Type:</strong> {{ $request->requested_type ?? '—' }}</div>
                        <div><strong>Description:</strong><br>{{ $request->requested_description ?? '—' }}</div>
                        <div class="edit-images-label"><strong>Requested Images:</strong></div>
                        <div class="edit-request-attachments horizontal">
                            @php
                                // Safe check: decode only if it's a string
                                $images = is_string($request->requested_image)
                                    ? json_decode($request->requested_image, true)
                                    : $request->requested_image;
                            @endphp

                            @if (!empty($images))
                                <div class="edit-request-attachments horizontal">
                                    @foreach ($images as $image)
                                        <img src="{{ asset('storage/' . $image) }}" alt="Edit Request Image"
                                            class="edit-thumbnail">
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            @if ($request->status === 'pending')
                <div class="edit-request-footer">
                    <!-- Accept Button inside Modal -->
                    <form method="POST"
                        action="{{ route('reporting.staff.updateRequest.accept', ['id' => $request->id]) }}"
                        class="form-accept">
                        @csrf
                        <button type="button" class="btn-accept">Accept</button>
                    </form>

                    <!-- Reject Button -->
                    <form method="POST"
                        action="{{ route('reporting.staff.updateRequest.reject', ['id' => $request->id]) }}"
                        class="form-reject">
                        @csrf
                        <button type="button" class="btn-reject">Reject</button>
                    </form>
                </div>
            @else
                <div class="edit-request-footer">
                    <span class="text-muted">Edit Request {{ ucfirst($request->status) }}</span>
                </div>
            @endif

        </div>
    </div>
</div>
