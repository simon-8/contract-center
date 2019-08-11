<?php
/**
 * Note: 用户签名
 * User: Liu
 * Date: 2019/6/27
 */
namespace App\Http\Controllers\Api;

use App\Models\Contract;
use App\Models\EsignUser;
use App\Models\Sign;
use App\Http\Resources\Sign as SignResource;
use App\Events\UserSign;
use App\Models\UserCompany;
use App\Services\ContractService;
use App\Services\EsignService;

class SignController extends BaseController
{
    /**
     * @param $id
     * @return string
     */
    protected function makeStorePath($id)
    {
        return 'signs/'. $id;
    }

    /**
     * 列表
     * @param Sign $sign
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Sign $sign)
    {
        $lists = $sign->where('userid', $this->user->id)
            ->paginate();
        return SignResource::collection($lists);
    }

    /**
     * 保存 (目前只有个人需要保存 公司直接选择已有)
     * @param \Request $request
     * @param Sign $sign
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(\Request $request, Sign $sign)
    {
        if (!$this->user->esignUser()->where('type', EsignUser::TYPE_PERSON)->count()) {
            return responseException('请先通过实名认证');
        }

        // todo 权限检查
        $data = $request::only(['contract_id']);
        if (!$request::hasFile('file')) {
            return responseException('请选择文件上传');
        }
        $file = $request::file('file');
        if (!$file->isValid()) {
            return responseException('图片文件无效');
        }
        // 存储图片
        $storePath = $this->makeStorePath($data['contract_id']);
        $filename = $this->user->id .'.'. $file->extension();
        $data['thumb'] = $file->storeAs($storePath, $filename, 'uploads');

        $data['userid'] = $this->user->id;

        $where = [
            'contract_id' => $data['contract_id'],
            'userid' => $data['userid']
        ];

        if (!$sign->updateOrCreate($where, $data)) {
            return responseException(__('api.failed'));
        }

        // 更新 contract
        $contract = Contract::find($data['contract_id']);

        if ($contract->userid_first == $this->user->id) {
            $contract->signed_first = 1;
        } else if ($contract->userid_second == $this->user->id) {
            $contract->signed_second = 1;
        } else if ($contract->userid_three == $this->user->id) {
            $contract->signed_three = 1;
        }

        // 参与方都签了名 直接修改状态
        if ($contract->players == $contract::PLAYERS_TWO) {
            if ($contract->signed_first && $contract->signed_second) {
                $contract->status = $contract::STATUS_SIGN;
            }
        } else if ($contract->players == $contract::PLAYERS_THREE) {
            if ($contract->signed_first && $contract->signed_second && $contract->signed_three) {
                $contract->status = $contract::STATUS_SIGN;
            }
        }

        $contract->save();

        // 触发usersign事件
        event(new UserSign($contract, $this->user));

        return responseMessage(__('api.success'));
    }

    /**
     * 更新
     * @param \Request $request
     * @param Sign $sign
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(\Request $request, Sign $sign)
    {
        if (!$request::hasFile('file')) {
            return responseException('请选择文件上传');
        }
        $file = $request::file('file');
        if (!$file->isValid()) {
            return responseException('图片文件无效');
        }
        // 存储图片
        $storePath = $this->makeStorePath($sign->contract_id);
        $filename = $this->user->id .'.'. $file->extension();
        $data['thumb'] = $file->storeAs($storePath, $filename, 'uploads');

        if (!$sign->update($data)) {
            return responseException(__('api.failed'));
        }
        return responseMessage(__('api.success'));
    }

    /**
     * 删除
     * @param Sign $sign
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Sign $sign)
    {
        if (!$sign->delete()) {
            return responseException(__('web.failed'));
        }
        return responseMessage(__('api.failed'));
    }

    /**
     * 确认签名 只有公司的签名需要确认
     * @param \Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function confirm(\Request $request)
    {
        $data = $request::only(['contract_id', 'sign_type', 'company_id', 'captcha']);

        //if ($data['sign_type'] == Contract::SIGN_TYPE_PERSON) {
        //    if (!$this->user->esignUser()->where('type', EsignUser::TYPE_PERSON)->exists()) {
        //        return responseException('请先通过实名认证');
        //    }
        //}

        //if ($data['sign_type'] == Contract::SIGN_TYPE_COMPANY) {
            if (empty($data['company_id'])) {
                return responseException('请选择签名企业');
            }
            if (!UserCompany::ofStatus(UserCompany::STATUS_SUCCESS)->whereId($data['company_id'])->exists()) {
                return responseException('签名企业未通过认证');
            }
        //}
        $companyData = UserCompany::ofStatus(UserCompany::STATUS_SUCCESS)->whereId($data['company_id'])->first();
        // 验证短信
        try {
            $esignService = new EsignService();
            $esignService->preVerifySignCodeToMobile($this->user->esignUser->accountid, $companyData->mobile, $data['captcha']);
        } catch (\Exception $e) {
            logger(__METHOD__, [$e->getMessage()]);
            return responseException($e->getMessage());
        }

        // 更新 contract signed_xxx  sign_type_xxx
        $contract = Contract::find($data['contract_id']);

        if ($contract->userid_first == $this->user->id) {

            $contract->signed_first = 1;
            $contract->sign_type_first = $data['sign_type'];
            $contract->companyid_first = $data['company_id'];

        } else if ($contract->userid_second == $this->user->id) {

            $contract->signed_second = 1;
            $contract->sign_type_second = $data['sign_type'];
            $contract->companyid_second = $data['company_id'];

        } else if ($contract->userid_three == $this->user->id) {

            $contract->signed_three = 1;
            $contract->sign_type_three = $data['sign_type'];
            $contract->companyid_three = $data['company_id'];

        }

        // 参与方都签了名 直接修改状态
        if ($contract->players == $contract::PLAYERS_TWO) {
            if ($contract->signed_first && $contract->signed_second) {
                $contract->status = $contract::STATUS_SIGN;
            }
        } else if ($contract->players == $contract::PLAYERS_THREE) {
            if ($contract->signed_first && $contract->signed_second && $contract->signed_three) {
                $contract->status = $contract::STATUS_SIGN;
            }
        }

        $contract->save();

        // 触发usersign事件
        event(new UserSign($contract, $this->user));

        return responseMessage(__('api.success'));
    }

    /**
     * 发送校验码 个人发给自己, 企业发给对应企业联系号码
     * @param \Request $request
     * @param EsignService $esignService
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendVerifyCode(\Request $request, EsignService $esignService)
    {
        $data = $request::only(['company_id']);
        try {
            // 个人
            if (empty($data['company_id'])) {
                $mobile = $this->user->mobile;
            } else {
                $companyData = UserCompany::find($data['company_id']);
                $mobile = $companyData['mobile'];
            }
            $esignService->sendSignCodeToMobile($this->user->esignUser->accountid, $mobile);
        } catch (\Exception $e) {
            logger(__METHOD__, [$e->getMessage()]);
            return responseException($e->getMessage());
        }
        return responseMessage(__('api.success'));
    }

    /**
     * 预先校验验证码
     * @param \Request $request
     * @param EsignService $esignService
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyCode(\Request $request, EsignService $esignService)
    {
        $data = $request::only(['code']);
        try {
            $esignService->preVerifySignCodeToMobile($this->user->esignUser->accountid, $this->user->mobile, $data['code']);
        } catch (\Exception $e) {
            logger(__METHOD__, [$e->getMessage()]);
            return responseException($e->getMessage());
        }
        return responseMessage(__('api.success'));
    }
}
