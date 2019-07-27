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
            $this->user->update(['vcompany' => 1]);
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
            ->orderByDesc('id')
            ->get();
        foreach ($lists as $k => $v) {
            $lists[$k] = new UserCompanyResource($v);
        }
        return responseMessage('', $lists);
    }
}
