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

            $user = Auth::user();
            
            \Log::info('Login Debug', [
                'user_id' => $user->id_pengguna,
                'email' => $user->email,
                'role' => $user->role,
            ]);

            $role = trim($user->role);
            
            if ($role === 'Admin') {
                \Log::info('Redirecting to admin dashboard');
                return redirect('/admin/dashboard');
            }

            \Log::info('Redirecting to user dashboard');
            return redirect('/dashboard');
            
        } catch (\Exception $e) {
            \Log::error('Login error: ' . $e->getMessage());
            return back()->withErrors([
                'email' => 'Login gagal. ' . $e->getMessage()
            ])->withInput();
        }
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Redirect ke halaman welcome (/)
        return redirect('/')->with('status', 'Anda telah berhasil logout.');
    }
}