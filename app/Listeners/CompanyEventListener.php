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

        try {

            if ($companyStaff->status == CompanyStaff::STATUS_APPLY) {
                // 用户申请加入
                $this->notifyToAdmin(SmsService::TPL_COMPANY_STAFF_USER_APPLY);

            } elseif ($companyStaff->status == CompanyStaff::STATUS_REFUSE) {
                // 申请被拒绝
                $this->notifyToUser(SmsService::TPL_COMPANY_STAFF_APPLY_STATUS);

            } elseif ($companyStaff->status == CompanyStaff::STATUS_SUCCESS) {
                // 申请通过
                $this->notifyToUser(SmsService::TPL_COMPANY_STAFF_APPLY_STATUS);

            } elseif ($companyStaff->status == CompanyStaff::STATUS_CANCEL) {
                // 管理员取消 || 用户主动取消
                if ($this->isAdmin) {
                    $this->notifyToUser(SmsService::TPL_COMPANY_STAFF_BE_CANCEL);
                } else {
                    $this->notifyToUser(SmsService::TPL_COMPANY_STAFF_USER_CANCEL);
                }
            }
        } catch (\Exception $exception) {
            logger(__METHOD__, [$exception->getCode(), $exception->getMessage()]);
        }
    }

    /**
     * @param $tpl
     * @throws \Exception
     */
    protected function notifyToAdmin($tpl)
    {
        $company = $this->companyStaff->company;
        $tplData = [];
        switch ($tpl) {
            case SmsService::TPL_COMPANY_STAFF_USER_APPLY:
                    $tplData = ['company' => $company->name];
                break;
            //case SmsService::TPL_COMPANY_STAFF_USER_APPLY_CANCEL:
            //        $tplData = ['company' => $company->name, 'status' => '统一'];
            //    break;
            default:
                break;
        }
        $this->smsService->sendTemplateSms($company->user->mobile, $tplData, $tpl, false);
    }

    /**
     * @param $tpl
     * @throws \Exception
     */
    protected function notifyToUser($tpl)
    {
        $company = $this->companyStaff->company;
        $user = $this->companyStaff->user;
        $tplData = [];
        switch ($tpl) {
            case SmsService::TPL_COMPANY_STAFF_APPLY_STATUS:
                $tplData = ['company' => $company->name];
                if ($this->companyStaff->status == CompanyStaff::STATUS_REFUSE) {
                    $tplData['status'] = '被拒绝';
                } elseif ($this->companyStaff->status == CompanyStaff::STATUS_SUCCESS) {
                    $tplData['status'] = '已通过';
                }
                break;
            case SmsService::TPL_COMPANY_STAFF_USER_CANCEL:
                $tplData = ['company' => $company->name, 'status' => '通过'];
                break;
            case SmsService::TPL_COMPANY_STAFF_BE_CANCEL:
                $tplData = ['company' => $company->name];
                break;
            default:
                break;
        }
        $this->smsService->sendTemplateSms($user->mobile, $tplData, $tpl, false);
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
