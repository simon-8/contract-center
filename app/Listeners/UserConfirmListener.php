<?php
/*
 * 双方用户确认 生成pdf文件
 * */
namespace App\Listeners;

use App\Events\UserConfirm;
use App\Models\Contract;
use App\Services\ContractService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserConfirmListener implements ShouldQueue
{
    public $tries = 1;

    public $contractService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        info(__METHOD__, [time()]);
        $this->contractService = new ContractService();
    }

    /**
     * Handle the event
     * @param UserConfirm $event
     *
     */
    public function handle(UserConfirm $event)
    {
        \Log::info(__METHOD__);

        // 双方确认后状态会变更为 STATUS_CONFIRM
        if ($event->contract->status != Contract::STATUS_CONFIRM) {
            return;
        }
        // 生成pdf文档
        $this->contractService->makePdf($event->contract);
    }

    /**
     * 处理失败任务。
     *
     * @param  \App\Events\UserConfirm  $event
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(UserConfirm $event, $exception)
    {
        info(__METHOD__, [$exception->getMessage()]);
    }
}
