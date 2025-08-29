<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Siniestro;
use App\Observers\SiniestroObserver;

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
        // Registra el observer del modelo Siniestro
        Siniestro::observe(SiniestroObserver::class);
    }
}
