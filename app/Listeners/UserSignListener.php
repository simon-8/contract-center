<?php

namespace App\Listeners;

use App\Events\UserSign;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserSignListener implements ShouldQueue
{
    public $tries = 1;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserSign  $event
     * @return void
     */
    public function handle(UserSign $event)
    {
        \Log::info(__METHOD__);
    }
}
