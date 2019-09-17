<?php
/**
 * Note: 用户填写企业信息store -> 发送短信验证码 -> 确认校验码并设置用户企业认证OK confirm
 * User: Liu
 * Date: 2019/7/9
 */
namespace App\Http\Controllers\Api;

use App\Http\Requests\UserCompanyRequest;
use App\Http\Requests\UserRequest;
use App\Models\EsignBank;
use App\Models\EsignBankArea;
use App\Models\EsignUser;
use App\Models\User;
use App\Models\UserCompany;
use App\Http\Resources\UserCompany as UserCompanyResource;
use App\Services\ContractService;
use App\Services\EsignService;
use App\Services\RealNameService;
use App\Services\SmsService;
use DB;
use Illuminate\Support\Facades\Storage;
use tech\constants\OrganizeTemplateType;
use tech\constants\SealColor;

class UserCompanyController extends BaseController
{
    /**
     * @param $id
     * @return string
     */
    protected function makeStorePath($id)
    {
        return '/signs/company/'. $id.'.png';
    }

    /**
     * 详情
     * @param UserCompany $userCompany
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(UserCompany $userCompany)
    {
        $userCompanyData = $userCompany::ofUserid($this->user->id)->first();
        if (!$userCompanyData) {
            return responseMessage('');
        }
        return responseMessage('', new UserCompanyResource($userCompanyData));
    }

    /**
     * 保存
     * @param UserCompanyRequest $request
     * @param UserCompany $userCompany
     * @param EsignService $esignService
     * @param RealNameService $realNameService
     * @param SmsService $smsService
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException|\Exception
     */
    public function store(UserCompanyRequest $request, UserCompany $userCompany, RealNameService $realNameService, SmsService $smsService)
    {
        $data = $request->all();
        $request->validateStore($data);

        $data['userid'] = $this->user->id;
        unset($data['sign_data']);

        if (empty($data['id'])) {
            if (UserCompany::whereName($data['name'])->exists()) {
                return responseException('该机构名称已认证');
            }
            if (UserCompany::whereOrganCode($data['organ_code'])->exists()) {
                return responseException('该机构号码已被使用');
            }
        }

        DB::beginTransaction();
        try {
            // 验证短信验证码
            //$smsService->verifyCode($data['mobile'], $data['captcha']);

            // E签宝信息验证
            $response = $realNameService->infoComAuth($data);
            if ($response) {
                $data['service_id'] = $response['serviceId'];
            }
            // 重置状态
            $data['status'] = UserCompany::STATUS_VERIFYD_INFO;

            $esignService = new EsignService();
            $userCompanyData = $userCompany::ofUserid($this->user->id)->first();
            if ($userCompanyData) {
                $esignUser = EsignUser::ofUserid($this->user->id)->ofType(EsignUser::TYPE_COMPANY)->first();
                /*
                 * 号码/类型变更 需要注销原账户, 然后添加账户
                 * 名称变更, 更新账户
                 * */
                if ($userCompanyData->organ_code != $data['organ_code'] || $userCompanyData->reg_type != $data['reg_type']) {

                    $esignService->delAccount($esignUser->accountid);
                    $accountid = $esignService->addOrganize($data);
                    $userCompanyData->update($data);

                } else if ($userCompanyData->name != $data['name']) {

                    $esignService->updateOrganize($esignUser->accountid, $data);
                    $userCompanyData->update($data);

                }

            } else {
                // 添加数据 并创建用户
                $userCompanyData = $userCompany::create($data);
                $accountid = $esignService->addOrganize($data);
            }
            // 有accountid 表示新增或accountid变更, 需要新增/更新EsignUser关联accountid
            if (!empty($accountid)) {
                EsignUser::updateOrCreate([
                    'userid' => $this->user->id,
                    'type' => EsignUser::TYPE_COMPANY,
                ], [
                    'accountid' => $accountid,
                ]);

                // 保存普通签名图片
                $contractService = new ContractService();
                $userCompanyData->sign_data = $contractService->makeSimpleSignData($userCompanyData->name);

                // 新建印章图片模板 红色圆形含五角星
                $base64 = $esignService->addOrganizeTemplateSeal($accountid);
                $userCompanyData->seal_img = $this->storeSignImage($base64);
                $userCompanyData->save();
            }
            //$this->user->update(['vcompany' => 1]);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return responseException($exception->getMessage());
        }

        return responseMessage(__('api.success'), new UserCompanyResource($userCompanyData));
    }

    /**
     * 保存印章图片
     * @param $base64
     * @return string
     * @throws \Exception
     */
    protected function storeSignImage($base64)
    {
        $storePath = $this->makeStorePath($this->user->id);
        $result = Storage::disk('uploads')->put($storePath, base64_decode($base64));
        if (!$result) {
            throw new \Exception('印章图片保存失败');
        }
        return $storePath;
    }

    /**
     * 普通搜索
     * @param \Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(\Request $request)
    {
        $data = $request::only(['name']);
        if (empty($data['name'])) {
            return responseMessage();
        }
        $lists = UserCompany::ofName($data['name'] ?? '')
            ->ofStatus(UserCompany::STATUS_SUCCESS)
            ->orderByDesc('id')
            ->get();
        foreach ($lists as $k => $v) {
            $lists[$k] = new UserCompanyResource($v);
        }
        return responseMessage('', $lists);
    }

    /**
     * 银行列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function bank()
    {
        $lists = EsignBank::select('bank_name')->groupBy('bank_name')->pluck('bank_name')->all();
        return responseMessage('', $lists);
    }

    /**
     * 查询支行列表
     * @param UserCompanyRequest $request
     * @param RealNameService $realNameService
     * @return \Illuminate\Http\JsonResponse
     */
    public function subBank(UserCompanyRequest $request, RealNameService $realNameService)
    {
        $data = $request->only(['subbranch']);
        if (empty($data['subbranch'])) {
            return responseException(__('api.empty_param'));
        }
        try {
            $response = $realNameService->organBankList([
                'keyword' => $data['subbranch']
            ]);
            $lists = $response['list'];
        } catch (\Exception $e) {
            return responseException('查询银行列表失败:'. $e->getMessage());
        }
        return responseMessage('', $lists);
    }

    /**
     * 获取所有地区
     * @param UserCompanyRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function area(UserCompanyRequest $request)
    {
        $lists = [];
        $areas = EsignBankArea::all();
        foreach ($areas as $k => $area) {
            $lists[$area['province']][] = $area['city'];
        }
        return responseMessage('', $lists);
    }

    /**
     * 申请打款
     * @param UserCompanyRequest $request
     * @param RealNameService $realNameService
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException|\Exception
     */
    public function toPay(UserCompanyRequest $request, RealNameService $realNameService, $id)
    {
        $data = $request->only([
            'name',
            'cardno',
            'subbranch',
            'bank',
            'province',
            'city',
        ]);
        $request->validateToPay($data);

        $userCompany = UserCompany::find($id);

        DB::beginTransaction();
        try {
            $data['notify'] = route('api.userCompanyOrder.notify', ['pid' => $id]);
            $data['service_id'] = $userCompany->service_id;
            $response = $realNameService->organPay($data, $id);

            $userCompany->status = UserCompany::STATUS_APPLY_PAY;
            $userCompany->save();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return responseException($exception->getMessage());
        }

        return responseMessage(__('api.success'), new UserCompanyResource($userCompany));
    }

    /**
     * 支付金额验证
     * @param UserCompanyRequest $request
     * @param RealNameService $realNameService
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function payAmountVerify(UserCompanyRequest $request, RealNameService $realNameService, $id)
    {
        $data = $request->only([
            'cash',
        ]);
        $userCompany = UserCompany::find($id);
        try {
            $data['service_id'] = $userCompany->service_id;
            $response = $realNameService->organPayAmountCheck($data);
            $userCompany->status = UserCompany::STATUS_SUCCESS;
        } catch (\Exception $e) {
            return responseException($e->getMessage());
        }
        return responseMessage(__('api.success'), new UserCompanyResource($userCompany));
    }

    /**
     * 发送短信
     * @param UserRequest $request
     * @param SmsService $smsService
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendCode(UserRequest $request, SmsService $smsService)
    {
        $data = $request->all();
        $request->validateSendSms($data);

        try {
            $smsService->sendVerifyCode($data['mobile']);
        } catch (\Exception $e) {
            return responseException($e->getMessage());
        }

        return responseMessage(__('api.success'));
    }
}
