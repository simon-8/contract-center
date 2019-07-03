<?php
/*
 * 双方用户确认 生成pdf文件
 * */
namespace App\Listeners;

use App\Events\UserConfirm;
use App\Models\Contract;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserConfirmListener implements ShouldQueue
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
     * @param  UserConfirm  $event
     * @return void
     */
    public function handle(UserConfirm $event)
    {
        \Log::info(__METHOD__);

        if ($event->contract->status != Contract::STATUS_CONFIRM) {
             return ;
        }
        // todo 生成PDF文件

    }
}
