<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
     public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                
                // Jika pengguna adalah admin, alihkan ke dashboard admin.
                if (Auth::user()->role === 'admin') {
                    return redirect(RouteServiceProvider::ADMIN_DASHBOARD);
                }
                
                // Jika pengguna terotentikasi tetapi bukan admin, alihkan ke HOME default.
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}