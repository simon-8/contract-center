<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

use Illuminate\Http\Resources\Json\Resource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Resource::withoutWrapping();

        // cn_mobile 不能正确识别 16 19号段, 且无法覆盖, 这里重写一个
        Validator::extend('cn_mobile', function ($attribute, $value) {
            return preg_match('/^(\+?0?86\-?)?(1[3456789]{1}\d{9})$/', $value);
        });
    }
}
