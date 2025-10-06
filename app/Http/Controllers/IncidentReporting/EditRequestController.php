<?php

namespace App\Http\Controllers\IncidentReporting;

use App\Http\Controllers\Controller;
use App\Models\IncidentReporting\EditRequest;
use RealRashid\SweetAlert\Facades\Alert;
use App\Notifications\ReportUser\EditRequestStatusNotification;
use Illuminate\Http\Request;

class EditRequestController extends Controller
{
    /**
     * Show all edit requests for staff (paginated)
     */
    public function index()
    {
        $editRequests = EditRequest::with(['user', 'report.images'])
            ->whereIn('status', ['pending', 'rejected', 'approved'])
            ->latest()
            ->paginate(10);

        return view('incident-reporting.staff-report.staff-edit-tbl', [
            'requests' => $editRequests,
        ]);
    }

    public function show($id)
    {
        $request = EditRequest::with(['user', 'report'])->find($id);

        // If the edit request itself was deleted
        if (!$request) {
            Alert::error('Deleted', 'The report you are trying to view has been deleted.')->autoClose(3000);
            return redirect()->route('staff.reporting.edit.index');
        }

        $report = $request->report;

        // If the original report was deleted
        if (!$report) {
            Alert::error('Deleted', 'The report associated with this request has been deleted.')->autoClose(3000);
            return redirect()->route('staff.reporting.edit.index');
        }

        return view('incident-reporting.staff-report.staff-show-edit-request', compact('request', 'report'));
    }

    /**
     * Accept an edit request and apply changes
     */
    public function accept($id)
    {
        $editRequest = EditRequest::with('report.images', 'user')->findOrFail($id);

        if ($editRequest->status !== 'pending') {
            Alert::warning('Already Reviewed', 'This request has already been processed.')->autoClose(3000);
            return back();
        }

        $report = $editRequest->report;

        // ✅ Apply requested changes only if provided
        $report->update([
            'report_title'       => $editRequest->requested_title       ?? $report->report_title,
            'report_date'        => $editRequest->requested_report_date ?? $report->report_date,
            'report_type'        => $editRequest->requested_type        ?? $report->report_type,
            'report_description' => $editRequest->requested_description ?? $report->report_description,
            'latitude'           => $editRequest->requested_latitude    ?? $report->latitude,
            'longitude'          => $editRequest->requested_longitude   ?? $report->longitude,
        ]);

        // ✅ Handle requested images
        if (!empty($editRequest->requested_image)) {
            $images = is_string($editRequest->requested_image)
                ? json_decode($editRequest->requested_image, true)
                : $editRequest->requested_image;

            if (is_array($images)) {
                // remove old images
                $report->images()->delete();

                // add new images
                foreach ($images as $imagePath) {
                    $report->images()->create([
                        'file_path' => $imagePath,
                    ]);
                }
            }
        }

        // ✅ Update the edit request
        $editRequest->update([
            'status'       => 'approved',
            'reviewed_by'  => auth()->id(),
            'reviewed_at'  => now(),
        ]);

        // ✅ Notify the user
        if ($editRequest->user) {
            $editRequest->user->notify(new EditRequestStatusNotification($editRequest, 'approved'));
        }

        Alert::success('Edit Request Approved', 'The changes have been applied successfully.')->autoClose(3000);

        return redirect()->route('staff.reporting.edit.index');
    }

    /**
     * Reject an edit request
     */
    public function reject($id)
    {
        $editRequest = EditRequest::findOrFail($id);

        if ($editRequest->status !== 'pending') {
            Alert::error('Already Reviewed', 'This request has already been processed.')->autoClose(3000);
            return back();
        }

        $editRequest->status = 'rejected';
        $editRequest->reviewed_by = auth()->id();
        $editRequest->reviewed_at = now();
        $editRequest->save();

        $editRequest->user->notify(new EditRequestStatusNotification($editRequest, 'rejected'));

        // ✅ Use SweetAlert "error" type so it shows a red ❌ icon
        Alert::error('Edit Request Rejected', 'The request has been rejected successfully.')->autoClose(3000);

        return back();
    }
}
