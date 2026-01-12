<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use App\Models\User;
use App\Models\Cliente;
use App\Models\TipoTramite;
use App\Models\Tramite;
use App\Observers\UserObserver;
use App\Observers\ClienteObserver;
use App\Observers\TipoTramiteObserver;
use App\Observers\TramiteObserver;

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
        // Observers
        User::observe(UserObserver::class);
        Cliente::observe(ClienteObserver::class);
        TipoTramite::observe(TipoTramiteObserver::class);
        Tramite::observe(TramiteObserver::class);
    }
}
