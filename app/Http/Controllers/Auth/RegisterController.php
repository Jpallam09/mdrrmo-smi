<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RegisterController extends Controller
{
    // Show registration form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration
     * @param \Illuminate\Http\Request $request
     */
    public function register(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'user_name'  => 'required|string|max:255|unique:users,user_name',
            'email'      => 'required|email|unique:users,email',
            'phone'      => 'required|string|max:20',
            'password'   => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create the user
        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name'  => $request->input('last_name'),
            'user_name'  => $request->input('user_name'),
            'email'      => $request->input('email'),
            'phone'      => $request->input('phone'),
            'password'   => Hash::make($request->input('password')),
        ]);

        // Assign default roles for both systems
        $user->roles()->createMany([
            ['app' => 'incident_reporting', 'role' => 'user'],
            ['app' => 'document_request',   'role' => 'user'],
        ]);

        // Log them in
        // Auth::login($user);
        Alert::success('Registration Successful!', 'Please login.');
        return redirect()->route('login');
    }
}
