<?php
/*
 * 给其他用户发送用户已签名短信通知
 * */
namespace App\Listeners;

use App\Events\UserSign;
use App\Services\SmsService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Storage;

class UserSignNotifyListener implements ShouldQueue
{
    use InteractsWithQueue;

    public $tries = 1;

    protected $smsService;

    /**
     * UserSignListener constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        info(__METHOD__, [time()]);
        $this->smsService = new SmsService();
    }

    /**
     * 用户签名
     * @param UserSign $event
     * @throws \Exception
     */
    public function handle(UserSign $event)
    {
        \Log::info(__METHOD__);

        $contract = $event->contract;
        $user = $event->user;

        // 发送已确认短信
        $smsService = new SmsService();
        $smsService->contractSigned($contract, $user);
    }

    /**
     * 处理失败任务。
     *
     * @param  \App\Events\UserSign  $event
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(UserSign $event, $exception)
    {
        info(__METHOD__, [$exception->getMessage()]);
    }
}
