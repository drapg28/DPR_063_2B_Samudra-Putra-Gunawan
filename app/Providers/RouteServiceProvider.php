<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/public/dashboard';
    public const ADMIN_DASHBOARD = '/admin/dashboard';

    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            // API Routes (jika ada)
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // Web Routes - PASTIKAN MIDDLEWARE WEB AKTIF
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}