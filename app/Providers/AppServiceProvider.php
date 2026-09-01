<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Forzar HTTPS en producción y detrás de proxies de EasyPanel
        if (config('app.env') === 'production' || app()->environment('production') || request()->header('X-Forwarded-Proto') === 'https' || !empty(request()->server('HTTP_X_FORWARDED_PROTO'))) {
            URL::forceScheme('https');
        }
    }
}
