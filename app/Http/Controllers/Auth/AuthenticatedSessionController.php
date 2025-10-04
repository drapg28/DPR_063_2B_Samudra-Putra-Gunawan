<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
{
    try {
        $request->authenticate();
        $request->session()->regenerate();

        // Debug: Log user info
        \Log::info('Login successful for user: ' . Auth::user()->email . ' with role: ' . Auth::user()->role);

        // Redirect berdasarkan role
        if (Auth::user()->role === 'Admin') {
            return redirect()->intended('/admin/dashboard');
        }

        return redirect()->intended('/dashboard');
    } catch (\Exception $e) {
        \Log::error('Login failed: ' . $e->getMessage());
        return back()->withErrors(['email' => 'Login gagal. Silakan coba lagi.']);
    }
}
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}