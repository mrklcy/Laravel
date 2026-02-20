<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PmoAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated as admin
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        // Check if the authenticated admin has pmo_admin role or is super_admin
        $admin = Auth::guard('admin')->user();
        if ($admin->role !== 'pmo_admin' && $admin->role !== 'super_admin') {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')->with('error', 'You do not have permission to access the PMO admin panel.');
        }

        return $next($request);
    }
}
