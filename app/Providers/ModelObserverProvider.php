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
        Article::observe('App\Observers\ArticleObserver');
        AdPlace::observe('App\Observers\AdPlaceObserver');
        Menu::observe('App\Observers\MenuObserver');
        Manager::observe('App\Observers\ManagerObserver');
        Roles::observe('App\Observers\RolesObserver');
        SinglePage::observe('App\Observers\SinglePageObserver');
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
