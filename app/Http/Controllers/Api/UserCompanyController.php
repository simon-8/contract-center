<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/7/9
 */
namespace App\Http\Controllers\Api;

use App\Http\Requests\UserCompanyRequest;
use App\Models\EsignUser;
use App\Models\UserCompany;
use App\Http\Resources\UserCompany as UserCompanyResource;
use App\Services\EsignService;
use DB;
use Illuminate\Support\Facades\Storage;

class UserCompanyController extends BaseController
{
    //public function index()
    //{
    //    $string = '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';
    //
    //    dd($this->storeSignImage($string));
    //}

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
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UserCompanyRequest $request, UserCompany $userCompany, EsignService $esignService)
    {
        $data = $request->all();
        $request->validateStore($data);

        $data['userid'] = $this->user->id;
        unset($data['sign_data']);
        DB::beginTransaction();
        try {
            //$upSignData = false;
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

                // 新建印章图片模板
                $base64 = $esignService->addOrganizeTemplateSeal($accountid);
                $userCompanyData->sign_data = $this->storeSignImage($base64);
                $userCompanyData->save();
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return responseException($exception->getMessage());
        }

        return responseMessage(__('api.success'));
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
}