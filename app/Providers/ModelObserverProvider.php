<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Article;
use App\Models\AdPlace;
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
        Article::observe('App\Observers\ArticleObserver');
        AdPlace::observe('App\Observers\AdPlaceObserver');
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
