<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login'); // Ini memperbaiki error 'Route [login] not defined.'
        }

        if ($request->user()->role !== $role) {
            abort(403, 'Akses Ditolak. Anda tidak memiliki hak akses sebagai ' . $role);
        }

        return $next($request);
    }
}