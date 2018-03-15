<?php
/**
 * Note: Blade服务提供器
 * User: Liu
 * Date: 2018/3/15
 */
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //\Blade::directive('calcHeight', function($width, $newWidth, $height) {
        //    $scale = intval($newWidth/$width);
        //    return $height * $scale;
        //});
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