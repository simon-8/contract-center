<?php

namespace App\Listeners;

use App\Events\CompanyEvent;

use App\Models\CompanyStaff;
use App\Services\SmsService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Storage;

class CompanyEventListener implements ShouldQueue
{
    public $tries = 1;

    public $companyStaff;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        info(__METHOD__, [time()]);
    }

    public function handle(CompanyEvent $event)
    {
        \Log::info(__METHOD__);

        $smsService = new SmsService();
        $companyStaff = $event->companyStaff;
        $company = $companyStaff->company;
        $admin = $company->user;
        $user = $companyStaff->user;

        try {
            if ($companyStaff->status == CompanyStaff::STATUS_APPLY) {
                // 通知管理员 用户提交申请
                $smsService->sendTemplateSms($admin->mobile, $company->name, 15573);
            } elseif ($companyStaff->status == CompanyStaff::STATUS_REFUSE) {
                // 通知用户 申请被拒绝
                $smsService->sendTemplateSms($user->mobile, $company->name, 15574);
            } elseif ($companyStaff->status == CompanyStaff::STATUS_SUCCESS) {
                // 通知用户 申请已通过
                $smsService->sendTemplateSms($user->mobile, $company->name, 15575);
            } elseif ($companyStaff->status == CompanyStaff::STATUS_CANCEL) {
                // 通知用户 用户已取消
                $smsService->sendTemplateSms($user->mobile, $company->name, 15576);
            }
        } catch (\Exception $exception) {
            logger(__METHOD__, [$exception->getCode(), $exception->getMessage()]);
        }
    }

    /**
     * 处理失败任务。
     *
     * @param  \App\Events\CompanyEvent  $event
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(CompanyEvent $event, $exception)
    {
        info(__METHOD__, [$exception->getMessage()]);
    }
}
