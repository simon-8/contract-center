<?php
/**
 * Note: 用户填写企业信息store -> 发送短信验证码 -> 确认校验码并设置用户企业认证OK confirm
 * User: Liu
 * Date: 2019/7/9
 */
namespace App\Http\Controllers\Api;

use App\Http\Requests\CompanyRequest;
use App\Http\Requests\UserRequest;
use App\Models\CompanyStaff;
use App\Models\Contract;
use App\Models\EsignBank;
use App\Models\EsignBankArea;
use App\Models\EsignUser;
use App\Models\User;
use App\Models\Company;
use App\Http\Resources\Company as CompanyResource;
use App\Services\ContractService;
use App\Services\EsignService;
use App\Services\RealNameService;
use App\Services\SmsService;
use DB;
use Illuminate\Support\Facades\Storage;
use tech\constants\OrganizeTemplateType;
use tech\constants\SealColor;

class CompanyController extends BaseController
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
     * @param Company $company
     * @return \Illuminate\Http\JsonResponse
     */
    //public function show(Company $company)
    //{
    //    $company['mobile'] = stringHide($company['mobile']);
    //    unset($company['legal_idno']);
    //    return responseMessage('', new CompanyResource($company));
    //}

    public function index(\Request $request)
    {
        //$userid = $request->
        return responseException('接口未开发');
    }

    /**
     * 我加入的
     * @param \Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function myJoin(\Request $request)
    {
        $companys = User::find($this->user->id)->joinCompany()->with('user')
            ->paginate();
        return CompanyResource::collection($companys);
    }

    /**
     * 我的
     * @param Company $company
     * @return \Illuminate\Http\JsonResponse
     */
    public function my(Company $company)
    {
        $companyData = $company::ofUserid($this->user->id)->first();
        if (!$companyData) {
            return responseMessage('');
        }
        $companyData->staff_count = $companyData->staff()
            ->where('status', CompanyStaff::STATUS_SUCCESS)
            ->count();
        $companyData->contract_count = Contract::ofCompanyId($companyData->id)
            ->ofStatus(Contract::STATUS_SIGN)
            ->count();
        return responseMessage('', new CompanyResource($companyData));
    }

    /**
     * 保存
     * @param CompanyRequest $request
     * @param Company $company
     * @param EsignService $esignService
     * @param RealNameService $realNameService
     * @param SmsService $smsService
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException|\Exception
     */
    public function store(CompanyRequest $request, Company $company, RealNameService $realNameService, SmsService $smsService)
    {
        $data = $request->all();
        $request->validateStore($data);

        $data['userid'] = $this->user->id;
        unset($data['sign_data']);

        if (empty($data['id'])) {
            if (Company::whereName($data['name'])->exists()) {
                return responseException('该机构名称已认证');
            }
            if (Company::whereOrganCode($data['organ_code'])->exists()) {
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
            $data['status'] = Company::STATUS_VERIFYD_INFO;

            $esignService = new EsignService();
            $companyData = $company::ofUserid($this->user->id)->first();
            if ($companyData) {
                $esignUser = EsignUser::ofUserid($this->user->id)->ofType(EsignUser::TYPE_COMPANY)->first();
                /*
                 * 号码/类型变更 需要注销原账户, 然后添加账户
                 * 名称变更, 更新账户
                 * */
                if ($companyData->organ_code != $data['organ_code'] || $companyData->reg_type != $data['reg_type']) {

                    $esignService->delAccount($esignUser->accountid);
                    $accountid = $esignService->addOrganize($data);
                    $companyData->update($data);

                } else if ($companyData->name != $data['name']) {

                    $esignService->updateOrganize($esignUser->accountid, $data);
                    $companyData->update($data);

                }

            } else {
                // 添加数据 并创建用户
                $companyData = $company::create($data);
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

                // 新建印章图片模板 红色圆形含五角星
                $base64 = $esignService->addOrganizeTemplateSeal($accountid);
                $companyData->seal_img = $this->storeSignImage($base64);
                $companyData->save();
            }
            //$this->user->update(['vcompany' => 1]);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return responseException($exception->getMessage());
        }

        return responseMessage(__('api.success'), new CompanyResource($companyData));
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
        $lists = Company::ofName($data['name'] ?? '')
            ->ofStatus(Company::STATUS_SUCCESS)
            ->orderByDesc('id')
            ->get();
        foreach ($lists as $k => $v) {
            $lists[$k] = new CompanyResource($v);
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
     * @param CompanyRequest $request
     * @param RealNameService $realNameService
     * @return \Illuminate\Http\JsonResponse
     */
    public function subBank(CompanyRequest $request, RealNameService $realNameService)
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
     * @param CompanyRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function area(CompanyRequest $request)
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
     * @param CompanyRequest $request
     * @param RealNameService $realNameService
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException|\Exception
     */
    public function toPay(CompanyRequest $request, RealNameService $realNameService, $id)
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

        $company = Company::find($id);

        DB::beginTransaction();
        try {
            $data['notify'] = route('api.companyOrder.notify', ['pid' => $id]);
            $data['service_id'] = $company->service_id;
            $response = $realNameService->organPay($data, $id);

            $company->status = Company::STATUS_APPLY_PAY;
            $company->save();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return responseException($exception->getMessage());
        }

        return responseMessage(__('api.success'), new CompanyResource($company));
    }

    /**
     * 支付金额验证
     * @param CompanyRequest $request
     * @param RealNameService $realNameService
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function payAmountVerify(CompanyRequest $request, RealNameService $realNameService, $id)
    {
        $data = $request->only([
            'cash',
        ]);
        $company = Company::find($id);
        try {
            $data['service_id'] = $company->service_id;
            $response = $realNameService->organPayAmountCheck($data);
            $company->status = Company::STATUS_SUCCESS;
        } catch (\Exception $e) {
            return responseException($e->getMessage());
        }
        return responseMessage(__('api.success'), new CompanyResource($company));
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
