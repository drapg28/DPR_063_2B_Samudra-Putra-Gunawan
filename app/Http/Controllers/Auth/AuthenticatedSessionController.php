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
        public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Logika Pengalihan (Redirect) Berdasarkan Role
        if (Auth::user()->role === 'admin') {
            // Ganti pengalihan ke konstanta URL dengan menggunakan nama rute (lebih andal) [!code focus]
            return redirect()->intended(route('admin.dashboard')); // [!code focus]
        }

        // Jika role adalah 'public' atau role lainnya, alihkan ke dashboard default
        return redirect()->intended(RouteServiceProvider::HOME);
    }

 
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}