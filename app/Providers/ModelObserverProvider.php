<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Activity;
use App\Models\AdPlace;
use App\Models\Menu;
use App\Models\Lottery;
use App\Models\LotteryApply;

class ModelObserverProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Activity::observe('App\Observers\ActivityObserver');
        AdPlace::observe('App\Observers\AdPlaceObserver');
        Menu::observe('App\Observers\MenuObserver');
        Lottery::observe('App\Observers\LotteryObserver');
        LotteryApply::observe('App\Observers\LotteryApplyObserver');
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
