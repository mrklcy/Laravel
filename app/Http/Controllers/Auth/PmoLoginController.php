<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PmoLoginController extends Controller
{
    /**
     * Show the PMO login form.
     */
    public function showLoginForm()
    {
        return view('auth.pmo-login');
    }

    /**
     * Handle a PMO admin login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $admin = Auth::guard('admin')->user();
            
            // Check if the admin has pmo_admin role
            if ($admin->role !== 'pmo_admin') {
                Auth::guard('admin')->logout();
                throw ValidationException::withMessages([
                    'email' => ['You do not have permission to access the PMO admin panel.'],
                ]);
            }

            $request->session()->regenerate();

            return redirect()->intended('/pmo/dashboard');
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials do not match our records.'],
        ]);
    }

    /**
     * Log the PMO admin out.
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/pmo/login');
    }
}
