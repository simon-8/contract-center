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
        $targetUsers = [];
        $sourceUserName = '';

        if ($contract->userid_first == $user->id) {
            $sourceUserName = $contract->jiafang;
            $targetUsers = [
                $contract->userSecond,
                $contract->userThree,
            ];

        } else if ($contract->userid_second == $user->id) {
            $sourceUserName = $contract->yifang;
            $targetUsers = [
                $contract->userFirst,
                $contract->userThree,
            ];

        } else if ($contract->userid_three == $user->id) {
            $sourceUserName = $contract->jujianren;
            $targetUsers = [
                $contract->userFirst,
                $contract->userSecond,
            ];
        }
        $smsData = [
            'title' => $contract->name,
            'name' => $sourceUserName
        ];
        foreach ($targetUsers as $targetUser) {
            if (!$targetUser) {
                continue;
            }
            if (!$targetUser->mobile) {
                logger(__METHOD__, ["合同ID: {$contract->id} 用户未绑定手机! 用户ID: {$targetUser->id}"]);
                return ;
            }
            $this->smsService->sendTemplateSms($targetUser->mobile, $smsData, $this->smsService::TEMPLATE_USER_SIGNED);
        }
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
