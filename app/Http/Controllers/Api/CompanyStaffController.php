<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/11/5
 * Time: 21:10
 */
namespace App\Http\Controllers\Api;

use App\Models\Company;
use App\Models\CompanyStaff;
use App\Http\Resources\CompanyStaff as CompanyStaffResource;
use App\Services\SmsService;


class CompanyStaffController extends BaseController
{
    /**
     * 状态
     * @param CompanyStaff $companyStaff
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStatus(CompanyStaff $companyStaff)
    {
        $statusArr = [
            CompanyStaff::STATUS_APPLY   => '待处理',
            CompanyStaff::STATUS_SUCCESS => '使用中',
            CompanyStaff::STATUS_CANCEL  => '已取消',
        ];
        return responseMessage('', $statusArr);
    }

    /**
     * 职员列表
     * @param \Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(\Request $request)
    {
        $data = $request::all();
        if (empty($data['company_id'])) {
            return responseException('缺失必要参数: company_id');
        }

        $lists = CompanyStaff::whereCompanyId($data['company_id'] ?? 0)
            ->ofStatus($data['status'] ?? '')
            ->with('user:id,truename,mobile')
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return CompanyStaffResource::collection($lists);
    }

    /**
     * 申请加入
     * @param \Request $request
     * @param SmsService $smsService
     * @return \Illuminate\Http\JsonResponse
     */
    public function apply(\Request $request, SmsService $smsService)
    {
        $data = $request::all();
        if (empty($data['company_id'])) {
            return responseException('缺少必要参数: company_id');
        }
        if (empty($data['captcha'])) {
            return responseException('缺少必要参数: captcha');
        }
        try {
            $smsService->verifyCode($this->user->mobile, $data['captcha']);
        } catch (\Exception $e) {
            return responseException($e->getMessage());
        }
        $staff = CompanyStaff::updateOrCreate([
            'userid' => $this->user->id,
            'company_id' => $data['company_id'],
        ], [
            'status' => CompanyStaff::STATUS_APPLY
        ]);
        return responseMessage(__('api.success'));
    }

    /**
     * 确认授权
     * @param \Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function confirm(\Request $request)
    {
        $data = $request::all();
        if (empty($data['company_id'])) {
            return responseException('缺少必要参数: company_id');
        }
        if (empty($data['userid'])) {
            return responseException('缺少必要参数: userid');
        }
        $companyData = Company::find($data['company_id']);
        if (!$companyData) {
            return responseException('公司不存在');
        }
        if ($companyData['userid'] != $this->user->id) {
            return responseException(__('api.no_auth'));
        }
        CompanyStaff::whereUserid($data['userid'])
            ->whereCompanyId($data['company_id'])
            ->update([
                'status' => CompanyStaff::STATUS_SUCCESS,
            ]);
        return responseMessage(__('api.success'));
    }

    /**
     * 拒绝
     * @param \Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function refuse(\Request $request)
    {
        $data = $request::all();
        if (empty($data['company_id'])) {
            return responseException('缺少必要参数: company_id');
        }
        if (empty($data['userid'])) {
            return responseException('缺少必要参数: userid');
        }
        $companyData = Company::find($data['company_id']);
        if (!$companyData) {
            return responseException('公司不存在');
        }
        if ($companyData['userid'] != $this->user->id) {
            return responseException(__('api.no_auth'));
        }
        CompanyStaff::whereUserid($data['userid'])
            ->whereCompanyId($data['company_id'])
            ->update([
                'status' => CompanyStaff::STATUS_REFUSE,
            ]);
        return responseMessage(__('api.success'));
    }

    /**
     * 取消授权
     * @param \Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel(\Request $request)
    {
        $data = $request::all();
        if (empty($data['company_id'])) {
            return responseException('缺少必要参数: company_id');
        }
        if (empty($data['userid'])) {
            return responseException('缺少必要参数: userid');
        }
        $companyData = Company::find($data['company_id']);
        if (!$companyData) {
            return responseException('公司不存在');
        }
        if ($companyData['userid'] != $this->user->id) {
            return responseException(__('api.no_auth'));
        }
        CompanyStaff::whereUserid($data['userid'])
            ->whereCompanyId($data['company_id'])
            ->update([
                'status' => CompanyStaff::STATUS_CANCEL,
            ]);
        return responseMessage(__('api.success'));
    }

    /**
     * 用户取消
     * @param \Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userCancel(\Request $request)
    {
        $data = $request::all();
        if (empty($data['company_id'])) {
            return responseException('缺少必要参数: company_id');
        }
        $companyData = Company::find($data['company_id']);
        if (!$companyData) {
            return responseException('公司不存在');
        }
        CompanyStaff::whereUserid($this->user->id)
            ->whereCompanyId($data['company_id'])
            ->update([
                'status' => CompanyStaff::STATUS_CANCEL,
            ]);
        return responseMessage(__('api.success'));
    }

    public function destroy(\Request $request)
    {

    }
}
