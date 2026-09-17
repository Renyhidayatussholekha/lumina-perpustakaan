<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS when behind reverse proxy, Cloudflare, localtunnel, or in production
        if (
            request()->header('x-forwarded-proto') === 'https' ||
            request()->isSecure() ||
            str_contains(request()->getHost(), 'trycloudflare.com') ||
            str_contains(request()->getHost(), 'loca.lt') ||
            str_contains(request()->getHost(), 'lhr.life') ||
            app()->environment('production')
        ) {
            URL::forceScheme('https');
        }
    }
}
