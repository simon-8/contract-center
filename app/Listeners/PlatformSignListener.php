<?php

namespace App\Listeners;

use App\Events\PlatformSign;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PlatformSignListener implements ShouldQueue
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
     * @param  PlatformSign  $event
     * @return void
     */
    public function handle(PlatformSign $event)
    {
        \Log::info(__METHOD__);
    }
}
