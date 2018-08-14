<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\Resource;

use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Horizon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //移除资源类data键
        Resource::withoutWrapping();

        Horizon::auth(function ($request) {
            return $request->user('admin') ? true : false;
        });
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
