<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncidentReporting\IncidentReportUserController;
use App\Http\Controllers\ProfileControllers\UserProfileController;
use App\Http\Controllers\IncidentReporting\FeedbackCommentController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPassController;

// ------------------ HOME ROUTE ------------------
Route::get('/', function () {
    return view('auth.index');
});

// ------------------ AUTH ROUTES ------------------
Route::prefix("auth")->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
        ->name('register');
    Route::post('/register', [RegisterController::class, 'register'])
        ->name('register.post');

    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login');
    Route::post('/login', [LoginController::class, 'login'])
        ->name('login.post');

    Route::get('/index', function () {
        return view('auth.index');
    })->name("index");

    Route::get('/forgot', [ForgotPassController::class, 'showForgot'])
        ->name("forgot");
    Route::post('/forgot', [ForgotPassController::class, 'sendResetLink'])
        ->name('password.email');

    // Reset Password
    Route::get('/reset-password/{token}', [ForgotPassController::class, 'showResetForm'])
        ->name('password.reset');
    Route::post('/reset-password', [ForgotPassController::class, 'resetPassword'])
        ->name('password.update');
});

// ------------------ GLOBAL LOGOUT ROUTE ------------------
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

// ------------------ USER INCIDENT REPORT ROUTES ------------------
Route::prefix('user/report')
    ->as('user.report.')
    ->middleware(['auth', 'prevent-back-history'])
    ->group(function () {

        // User Main Dashboard
        Route::get('/home', function () {
            return view('user.user-home');
        })->name("home");

        // List all reports (dashboard for reporting)
        Route::get('/list', [IncidentReportUserController::class, 'index'])
            ->name("list");

        // Create / Store Report
        Route::get('/create', [IncidentReportUserController::class, 'create'])
            ->name('create');
        Route::post('/store', [IncidentReportUserController::class, 'store'])
            ->name('store');

        // View a single report
        Route::get('/view/{id}', [IncidentReportUserController::class, 'viewReport'])
            ->name('view');

        // Edit / Update Report
        Route::get('/edit/{id}', [IncidentReportUserController::class, 'edit'])
            ->name('edit');
        Route::put('/update/{id}', [IncidentReportUserController::class, 'update'])
            ->name('update');

        // Request Update (approval workflow)
        Route::put('/request-update/{id}', [IncidentReportUserController::class, 'requestUpdate'])
            ->name('requestUpdate');

        // Request Delete (approval workflow)
        Route::delete('/request-delete/{incidentReportUser}', [IncidentReportUserController::class, 'requestDelete'])
            ->name('delete');

        // Notifications
        Route::get('/notifications/{id}/mark-read', [IncidentReportUserController::class, 'markAsRead'])
            ->name('notifications.markRead');

        // Profile
        Route::get('/profile', [UserProfileController::class, 'show'])
            ->name('profile.show');
        Route::post('/profile/update', [UserProfileController::class, 'updateInfo'])
            ->name('profile.update');

        // Feedback & Comments
        Route::post('/view/{id}/feedback', [FeedbackCommentController::class, 'store'])
            ->name('feedback.store');
        Route::get('/my-feedback', [FeedbackCommentController::class, 'myFeedback'])
            ->name('feedback.myFeedback');
    });

require __DIR__ . '/incidentReporting.php';
