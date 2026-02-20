<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RmoAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated as admin
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')->with('error', 'Please login to access RMO admin panel.');
        }

        // Check if user has rmo_admin role
        $admin = Auth::guard('admin')->user();
        if ($admin->role !== 'rmo_admin' && $admin->role !== 'super_admin') {
            abort(403, 'Unauthorized access to RMO admin panel.');
        }

        return $next($request);
    }
}
