<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Make sure this is imported
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle the login request
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            /** @var User $user */
            $user = Auth::user(); // Explicit cast for Intelephense
            $user->load('roles'); // Now no more "undefined method" warning

            // Staff
            if ($user->hasRole('incident_reporting', 'staff')) {
                return redirect()->intended(route('staff.report.dashboard'));
            }

            // Default: Normal User
            return redirect()->intended(route('user.report.home'));
        }

        // FAILED LOGIN
        return back()->withErrors([
            'email' => 'Invalid credentials. Please try again.',
        ])->onlyInput('email');
    }

    // Handle logout
public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');//redirect to login route
}


}
