<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use illuminate\rauting\urlGenerator;

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
    public function boot(UrlGenerator $url): void
    {
        if (app()->environment() !== 'production') {
            $this->configureNumberFormatting();
            $url->forceScheme('https');
        }
    }
}
