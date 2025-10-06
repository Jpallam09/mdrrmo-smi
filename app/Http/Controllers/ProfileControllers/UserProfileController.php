<?php

namespace App\Http\Controllers\ProfileControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        return view('user.report.user-profile', compact('user'));
    }

    public function updateInfo(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // 1. Validate input
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'user_name'        => 'required|string|max:255|unique:users,user_name,' . $user->getKey(),
            'phone' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        // 2. Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old picture if exists
            if ($user->profile_picture && Storage::disk('public')->exists('profile_pictures/' . $user->profile_picture)) {
                Storage::disk('public')->delete('profile_pictures/' . $user->profile_picture);
            }

            // Store new picture
            $file = $request->file('profile_picture');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('profile_pictures', $filename, 'public');

            $user->profile_picture = $filename;
        }

        // 3. Update other user info
        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        $user->user_name  = $validated['user_name'];
        $user->phone = $validated['phone'] ?? null;

        $user->save();

        // 4. SweetAlert success and redirect
        Alert::success('Success', 'Profile updated successfully!');
        return redirect()->back();
    }
}
