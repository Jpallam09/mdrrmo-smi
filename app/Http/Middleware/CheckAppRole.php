<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAppRole
{
    /**
     * Ensure the authenticated user has the required role for a given app.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $app   App identifier: 'incident_reporting' or 'document_request'
     * @param  string  $role  Role: 'user', 'staff', or 'admin'
     */
    public function handle(Request $request, Closure $next, string $app, string $role)
    {
        $user = $request->user();

        // Check if user is logged in and has correct role for the app
        if (! $user || ! $user->hasRole($app, $role)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
