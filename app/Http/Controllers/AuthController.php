<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin()
    {
        // If already logged in, redirect to appropriate dashboard
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user();
            
            if ($admin->role === 'pmo_admin') {
                return redirect()->route('pmo.dashboard');
            }
            
            if ($admin->role === 'hrmo_admin') {
                return redirect()->route('admin.hrm.dashboard');
            }
            
            if ($admin->role === 'pso_admin') {
                return redirect()->route('pso.dashboard');
            }
            
            if ($admin->role === 'rmo_admin') {
                return redirect()->route('rmo.dashboard');
            }
            
            return redirect()->route('admin.dashboard');
        }
        
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->has('remember');

        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            $admin = Auth::guard('admin')->user();
            
            // Redirect based on role
            if ($admin->role === 'pmo_admin') {
                return redirect()->route('pmo.dashboard')
                    ->with('success', 'Welcome back, ' . $admin->name . '!');
            }
            
            if ($admin->role === 'hrmo_admin') {
                return redirect()->route('admin.hrm.dashboard')
                    ->with('success', 'Welcome back, ' . $admin->name . '!');
            }

            if ($admin->role === 'pso_admin') {
                return redirect()->route('pso.dashboard')
                    ->with('success', 'Welcome back, ' . $admin->name . '!');
            }

            if ($admin->role === 'rmo_admin') {
                return redirect()->route('rmo.dashboard')
                    ->with('success', 'Welcome back, ' . $admin->name . '!');
            }
            
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Welcome back, ' . $admin->name . '!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login')
            ->with('success', 'You have been logged out successfully.');
    }
}
