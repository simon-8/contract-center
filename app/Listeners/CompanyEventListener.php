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
        $user = $companyStaff->user;

        try {
            $template = '';
            $mobile = $user->mobile;
            if ($companyStaff->status == CompanyStaff::STATUS_APPLY) {
                // 通知管理员 用户提交申请
                $template = SmsService::TEMPLATE_COMPANY_STAFF_APPLY;
                // 使用管理员手机号码
                $mobile = $company->user->mobile;
            } elseif ($companyStaff->status == CompanyStaff::STATUS_REFUSE) {
                // 通知用户 申请被拒绝
                $template = SmsService::TEMPLATE_COMPANY_STAFF_REFUSE;

            } elseif ($companyStaff->status == CompanyStaff::STATUS_SUCCESS) {
                // 通知用户 申请已通过
                $template = SmsService::TEMPLATE_COMPANY_STAFF_SUCCESS;

            } elseif ($companyStaff->status == CompanyStaff::STATUS_CANCEL) {
                // 通知用户 用户已取消
                $template = SmsService::TEMPLATE_COMPANY_STAFF_CANCEL;
            }
            $smsService->sendTemplateSms($mobile, ['company' => $company->name,], $template, false);
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
