<?php

namespace App\Providers;

use App\Models\Cotizacion;
use App\Models\Servicio;
use App\Observers\CotizacionObserver;
use App\Observers\ServicioObserver;
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
        Cotizacion::observe(CotizacionObserver::class);
        Servicio::observe(ServicioObserver::class);
    }
}
