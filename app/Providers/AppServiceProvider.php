<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Blade::if('hasStartedSeries', function($series) {
            return auth()->user()->hasStartedSeries($series);
        });

        Blade::if('admin', function() {
            return auth()->user()->isAdmin();
        });

        Cashier::useCurrency('aud', '$');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
