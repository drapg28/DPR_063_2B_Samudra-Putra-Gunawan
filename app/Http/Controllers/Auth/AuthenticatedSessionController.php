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
    /**
     * Tampilkan tampilan login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Tangani permintaan otentikasi masuk.
     * Logika ini dimodifikasi untuk mengalihkan berdasarkan role user.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Logika Pengalihan (Redirect) Berdasarkan Role
        if (Auth::user()->role === 'admin') {
            // Jika role adalah 'admin', alihkan ke dashboard admin
            return redirect()->intended(RouteServiceProvider::ADMIN_DASHBOARD);
        }

        // Jika role adalah 'public' atau role lainnya, alihkan ke dashboard default
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Hancurkan sesi (Logout).
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
