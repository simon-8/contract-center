<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Article;
use App\Models\AdPlace;
use App\Models\Menu;
use App\Models\Manager;
use App\Models\Roles;
use App\Models\SinglePage;

class ModelObserverProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Article::observe(\App\Observers\ArticleObserver::class);
        AdPlace::observe(\App\Observers\AdPlaceObserver::class);
        Menu::observe(\App\Observers\MenuObserver::class);
        Manager::observe(\App\Observers\ManagerObserver::class);
        Roles::observe(\App\Observers\RolesObserver::class);
        SinglePage::observe(\App\Observers\SinglePageObserver::class);
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
