<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }
        // Redirect non-admin users or show 403 Forbidden
        abort(403, 'Akses Ditolak. Hanya untuk Admin.');
    }
}
