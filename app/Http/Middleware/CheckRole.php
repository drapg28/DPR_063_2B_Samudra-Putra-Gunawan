<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Debug log
        \Log::info('CheckRole middleware', [
            'authenticated' => Auth::check(),
            'user' => Auth::user(),
            'required_role' => $role,
            'user_role' => Auth::check() ? Auth::user()->role : 'not authenticated'
        ]);

        if (!Auth::check()) {
            \Log::warning('User not authenticated');
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Role checking - PENTING: Case-sensitive sesuai database
        if (Auth::user()->role === $role) {
            \Log::info('Role check passed');
            return $next($request);
        }

        \Log::warning('Role check failed', [
            'user_role' => Auth::user()->role,
            'required_role' => $role
        ]);

        return redirect('/')->with('error', 'Akses Ditolak: Anda tidak memiliki izin sebagai ' . $role . '.');
    }
}