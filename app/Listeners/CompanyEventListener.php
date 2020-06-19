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

    public $isAdmin;

    public $smsService;

    /**
     * CompanyEventListener constructor.
     * @param SmsService $smsService
     */
    public function __construct(SmsService $smsService)
    {
        info(__METHOD__, [time()]);
        $this->smsService = $smsService;
    }

    public function handle(CompanyEvent $event)
    {
        \Log::info(__METHOD__);

        $companyStaff = $this->companyStaff = $event->companyStaff;
        $this->isAdmin = $event->isAdmin;

        $smsService = new SmsService();
        try {

            if ($companyStaff->status == CompanyStaff::STATUS_APPLY) {
                // 用户申请加入
                $smsService->companyStaffUserApply($companyStaff);

            } elseif ($companyStaff->status == CompanyStaff::STATUS_REFUSE) {
                // 申请被拒绝
                $smsService->companyStaffApplyStatus($companyStaff);
            } elseif ($companyStaff->status == CompanyStaff::STATUS_SUCCESS) {
                // 申请通过
                $smsService->companyStaffApplyStatus($companyStaff);

            } elseif ($companyStaff->status == CompanyStaff::STATUS_CANCEL) {
                // 管理员取消 || 用户主动取消
                $this->isAdmin ? $smsService->companyStaffBeCancel($companyStaff) : $smsService->companyStaffUserCancel($companyStaff);
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
