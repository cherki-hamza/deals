<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Register Product Observer for notifications
        \App\Models\Product::observe(\App\Observers\ProductObserver::class);

        // Register Deal Observer for notifications
        \App\Models\Deal::observe(\App\Observers\DealObserver::class);
    }
}
