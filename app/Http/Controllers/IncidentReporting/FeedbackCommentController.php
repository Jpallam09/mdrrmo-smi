<?php

namespace App\Http\Controllers\IncidentReporting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeedbackComment;
use RealRashid\SweetAlert\Facades\Alert;
use App\Notifications\ReportUser\FeedbackSubmitted;
use App\Models\User;

class FeedbackCommentController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        // Save feedback and assign to variable
        $feedback = FeedbackComment::create([
            'user_id' => auth()->id(),
            'report_id' => $id,
            'comment' => $request->comment,
        ]);

        // Notify all staff users
        $staffUsers = User::whereHas('roles', fn($q) => $q->where('role', 'staff'))->get();

        foreach ($staffUsers as $staff) {
            $staff->notify(new FeedbackSubmitted(
                $feedback->report_id,
                auth()->user()->user_name,
                $feedback->comment
            ));
        }

        Alert::success('Thank you!', 'Your feedback has been submitted successfully.');
        return redirect()->back();
    }
}
