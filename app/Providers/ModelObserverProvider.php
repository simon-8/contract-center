<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Menu;

class ModelObserverProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Menu::observe('App\Observers\MenuObserver');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
