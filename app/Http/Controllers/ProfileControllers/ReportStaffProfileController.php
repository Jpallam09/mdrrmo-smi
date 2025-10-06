<?php

namespace App\Http\Controllers\ProfileControllers;

use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportStaffProfileController extends Controller
{
    // Show staff profile
    public function show()
    {

        $staff = Auth::user(); // Correct: get currently logged-in staff
        return view('incident-reporting.staff-report.staff-profile', compact('staff')); // pass $staff to view
    }

    // Update staff profile info
    public function updateInfo(Request $request)
    {
        /** @var \App\Models\User $staff */
        $staff = Auth::user(); // always use Auth::user()

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'user_name'  => 'required|string|max:255|unique:users,user_name,' . $staff->getKey(),
            'phone'      => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        $staff->first_name = $request->first_name;
        $staff->last_name  = $request->last_name;
        $staff->user_name  = $request->user_name;
        $staff->phone      = $request->phone;

        if ($request->hasFile('profile_picture')) {
            $filename = $request->file('profile_picture')->store('profile_pictures', 'public');
            $staff->profile_picture = basename($filename);
        }

        $staff->save();

        Alert::success('Success', 'Profile updated successfully!');
        return redirect()->back();
    }
}
