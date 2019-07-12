<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        //Registered::class => [
        //    SendEmailVerificationNotification::class,
        //],
        \Illuminate\Database\Events\QueryExecuted::class => [
            \App\Listeners\DBQueryListener::class
        ],
        // 用户确认
        'App\Events\UserConfirm' => [
            'App\Listeners\UserConfirmListener'
        ],
        // 用户签名
        'App\Events\UserSign' => [
            'App\Listeners\UserSignListener',
            'App\Listeners\UserSignNotifyListener',

        ],
        // 系统签名
        'App\Events\PlatformSign' => [
            'App\Listeners\PlatformSignListener'
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
