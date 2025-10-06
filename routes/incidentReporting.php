<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncidentReporting\IncidentReportStaffController;
use App\Http\Controllers\IncidentReporting\FeedbackCommentController;
use App\Http\Controllers\IncidentReporting\EditRequestController;
use App\Http\Controllers\IncidentReporting\DeleteRequestController;
use App\Http\Controllers\ProfileControllers\ReportStaffProfileController;

Route::prefix('incidentReporting')
    ->middleware('auth')
    ->group(function () {

        // STAFF ROUTES
        Route::prefix('staffReporting')
            ->middleware(['check.role:incident_reporting,staff', 'prevent-back-history'])
            ->as('staff.report.')
            ->group(function () {

                // Dashboard
                Route::get('/dashboard', [IncidentReportStaffController::class, 'dashboard'])
                    ->name('dashboard');

                // View all reports
                Route::get('/report-lists', [IncidentReportStaffController::class, 'staffReportView'])
                    ->name('list');

                // View a single report
                Route::get('/view/{id}', [IncidentReportStaffController::class, 'staffViewReportsFullDetails'])
                    ->name('view');

                // Export report as PDF
                Route::get('/view/{id}/export-pdf', [IncidentReportStaffController::class, 'exportPdf'])
                    ->name('exportPdf');

                // Track Report
                Route::get('/view/{id}/track', [IncidentReportStaffController::class, 'ShowTrackReport'])
                    ->name('track.show');
                Route::post('/trackReport', [IncidentReportStaffController::class, 'trackReport'])
                    ->name('track.create');
                Route::post('/trackReport/{id}/success', [IncidentReportStaffController::class, 'successTrack'])
                    ->name('track.success');
                Route::post('/trackReport/{id}/cancel', [IncidentReportStaffController::class, 'cancelTrack'])
                    ->name('track.cancel');

                // ---------- Edit Requests ----------
                Route::get('/edit-requests', [EditRequestController::class, 'index'])
                    ->name('edit.index');
                Route::get('/edit-requests/{id}', [EditRequestController::class, 'show'])
                    ->name('edit.show');
                Route::post('/edit-requests/{id}/accept', [EditRequestController::class, 'accept'])
                    ->name('edit.accept');
                Route::post('/edit-requests/{id}/reject', [EditRequestController::class, 'reject'])
                    ->name('edit.reject');

                // ---------- Delete Requests ----------
                Route::get('/delete-requests', [DeleteRequestController::class, 'index'])
                    ->name('delete.index');
                Route::get('/delete-requests/{id}', [DeleteRequestController::class, 'show'])
                    ->name('delete.show');
                Route::post('/delete-requests/{id}/accept', [DeleteRequestController::class, 'accept'])
                    ->name('delete.accept');
                Route::post('/delete-requests/{id}/reject', [DeleteRequestController::class, 'reject'])
                    ->name('delete.reject');

                // Charts
                Route::get('/monthly-trend', [IncidentReportStaffController::class, 'getMonthlyReportTrend'])
                    ->name('chart.monthlyTrend');
                Route::get('/report-type', [IncidentReportStaffController::class, 'getReportTypeChart'])
                    ->name('chart.reportType');

                // Profile
                Route::get('/profile', [ReportStaffProfileController::class, 'show'])
                    ->name('profile.show');
                Route::post('/profile/update', [ReportStaffProfileController::class, 'updateInfo'])
                    ->name('profile.update');

                // Feedback
                Route::get('/view/{report_id}/feedback/{feedback_id}', [FeedbackCommentController::class, 'show'])
                    ->name('feedback.show');
                Route::post('/view/{id}/feedback/destroy', [FeedbackCommentController::class, 'destroy'])
                    ->name('feedback.destroy');

                // Notifications
                Route::get('/notifications/mark-read/{id}', [IncidentReportStaffController::class, 'markNotificationRead'])
                    ->name('notifications.markRead');
            });
    });
