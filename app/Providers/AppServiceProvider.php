<?php

namespace App\Providers;

use App\View\Composers\SystemSettingsComposer;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Register view composer for system settings
        View::composer(['adminlte::page', 'layouts.app', 'layouts.admin'], SystemSettingsComposer::class);
    }
}
