<?php
/**
 * Note: 用户实名
 * tip 图片文件名使用userid, 图片更新后地址不会更新, 浏览器会认为是同一张图片
 * 返回时需要加上rand参数
 *
 * 流程:
 * 用户上传身份证正反面(store)
 * 点击上传, OCR识别身份证(update), 返回识别信息, 客户端提示用户确认,
 * 用户确认, 保存资料(confirm)
 * 用户取消, 删除资料(cancel)
 *
 * 确认资料后创建E签名账户
 * User: Liu
 * Date: 2019/7/1
 */
namespace App\Http\Controllers\Api;

use App\Http\Requests\UserRealNameRequest;
use App\Models\EsignUser;
use App\Models\UserRealName;

use App\Http\Resources\UserRealName as UserRealNameResource;
use App\Services\ContractService;
use App\Services\EsignFaceService;
use App\Services\EsignService;
use App\Services\Ocr\IdCardService;
use App\Services\RealNameService;
use \DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use tech\constants\PersonTemplateType;
use tech\constants\SealColor;

class UserRealNameController extends BaseController
{
    protected $cacheKeyPrefix = 'idcardInfo';

    /**
     * @return string
     */
    protected function makeCacheKey()
    {
        return 'idcardInfo_'.$this->user->uid;
    }

    /**
     * 设置缓存
     * @param Model $userRealNameData
     */
    protected function storeCache(Model $userRealNameData)
    {
        $data = $userRealNameData->toArray();
        unset($data['face_img'], $data['back_img'], $data['id']);
        Cache::put($this->makeCacheKey(), $data, 3600);
    }

    /**
     * 读取缓存
     * @return mixed
     */
    protected function getCache()
    {
        return Cache::get($this->makeCacheKey());
    }

    /**
     * 删除缓存
     */
    protected function clearCache()
    {
        Cache::forget($this->makeCacheKey());
    }


    /**
     * @param UserRealName $userRealName
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(UserRealName $userRealName)
    {
        $userRealNameData = $userRealName::ofUserid($this->user->id)->first();
        if (!$userRealNameData) {
            return responseMessage('');
        }
        return responseMessage('', new UserRealNameResource($userRealNameData));
    }

    /**
     * 生成保存目录
     * @return string
     */
    protected function makeStoreDir()
    {
        return '/idcards/'. ($this->user->id%10);
    }

    /**
     * 保存 兼并 更新
     * @param UserRealNameRequest $request
     * @param UserRealName $userRealName
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException|\Exception
     */
    public function store(UserRealNameRequest $request, UserRealName $userRealName)
    {
        $data = $request->all();
        $request->validateStore($data);

        logger(__METHOD__, $data);
        // 使用userid作为文件名 更新时可直接覆盖
        if ($request->hasFile('face_img')) {
            $faceUrl = $request->file('face_img');
            $filename = $this->user->id .'.'. $faceUrl->extension();
            $data['face_img'] = $faceUrl->storeAs($this->makeStoreDir(), $filename, 'uploads');
        }

        // 使用userid作为文件名 更新时可直接覆盖
        if ($request->hasFile('back_img')) {
            $backUrl = $request->file('back_img');
            $filename = $this->user->id .'_1.'. $backUrl->extension();
            $data['back_img'] = $backUrl->storeAs($this->makeStoreDir(), $filename, 'uploads');
        }

        DB::beginTransaction();
        try {
            // 重置所有数据
            $data['userid'] = $this->user->id;
            $data['nationality'] = '';
            $data['idcard'] = '';
            $data['sex'] = '';
            $data['birth'] = '';
            $data['address'] = '';
            $data['start_date'] = '';
            $data['end_date'] = '';
            $data['issue'] = '';

            // 查询条件
            $w = [
                'userid' => $this->user->id
            ];
            $userRealNameData = $userRealName::updateOrCreate($w, $data);

            // 重置个人实名状态
            $this->user->update(['vtruename' => 0]);

            DB::commit();
        } catch (\Exception $e) {
            logger(__METHOD__, [$e->getMessage()]);
            DB::rollBack();
            return responseException(__('api.failed'));
        }
        return responseMessage('', new UserRealNameResource($userRealNameData));
    }

    /**
     * 通过接口查询身份证信息并缓存查询到的信息
     * @param IdCardService $idCardService
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(IdCardService $idCardService)
    {
        $userRealNameData = UserRealName::ofUserid($this->user->id)->first();

        // 查询身份证正面数据
        $faceImgPath = Storage::disk('uploads')->path($userRealNameData->face_img);
        try {
            $idInfo = $idCardService->getData($faceImgPath, 'face');
            if (!$idInfo || !$idInfo['success']) {
                throw new \Exception('正面无结果或success字段不为true');
            }
            $userRealNameData->truename  = $idInfo['name'];
            $userRealNameData->nationality  = $idInfo['nationality'];
            $userRealNameData->idcard  = $idInfo['num'];
            $userRealNameData->sex  = $idInfo['sex'];
            $userRealNameData->birth  = $idInfo['birth'];
            $userRealNameData->address  = $idInfo['address'];
        } catch (\Exception $e) {
            logger(__METHOD__, [$e->getMessage()]);
            return responseException('身份证正面识别失败');
        }

        if (UserRealName::whereIdcard($userRealNameData->idcard)->exists()) {
            return responseException('该身份证号码已被其他用户验证');
        }
        // 查询身份证反面数据
        $backImgPath = Storage::disk('uploads')->path($userRealNameData->back_img);
        try {
            $idBackInfo = $idCardService->getData($backImgPath, 'back');
            if (!$idBackInfo || !$idBackInfo['success']) {
                throw new \Exception('反面无结果或success字段不为true');
            }
            $userRealNameData->start_date  = $idBackInfo['start_date'];
            $userRealNameData->end_date  = $idBackInfo['end_date'];
            $userRealNameData->issue  = $idBackInfo['issue'];
        } catch (\Exception $e) {
            logger(__METHOD__, [$e->getMessage()]);
            return responseException('身份证反面识别失败');
        }

        // 放至缓存 确认后使用
        $this->storeCache($userRealNameData);

        return responseMessage('', new UserRealNameResource($userRealNameData));
    }

    /**
     * 删除
     * @param UserRealName $userRealName
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(UserRealName $userRealName)
    {
        $userRealNameData = $userRealName::ofUserid($this->user->id)->first();

        if (!$userRealNameData->delete()) {
            return responseException(__('web.failed'));
        }
        return responseMessage(__('api.success'));
    }

    /**
     * 身份确认, 确认后读取缓存数据, 整合后保存身份信息
     * @param UserRealNameRequest $request
     * @param UserRealName $userRealName
     * @param EsignService $esignService
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function confirm(UserRealNameRequest $request, UserRealName $userRealName, EsignService $esignService)
    {
        $truename = $request->input('truename');
        $idcard = $request->input('idcard');
        if (empty($idcard) || empty($truename)) {
            return responseException(__('api.empty_param'));
        }

        $userRealNameData = $userRealName::ofUserid($this->user->id)->first();
        if (!$userRealNameData) {
            return responseException(__('api.no_result'));
        }
        $userRealNameData->truename = $truename;
        $userRealNameData->idcard = $idcard;

        // 从缓存中拿值
        $cacheData = $this->getCache();
        if (empty($cacheData)) {
            return responseException(__('api.expired'));
        }
        $userRealNameData->fill($cacheData);

        DB::beginTransaction();
        try {

            // E签宝个人实名认证  个人三要素认证
            $realNameService = new RealNameService();
            $checkData = [
                'mobile' => $this->user->mobile,
                'name' => $userRealNameData->truename,
                'idno' => $userRealNameData->idcard,
            ];
            $result = $realNameService->teleComAuth($checkData);
            logger(__METHOD__, ['msg' => '个人实名检查成功', 'checkData' => $checkData, 'result' => $result]);

            if (!$userRealNameData->save()) {
                throw new \Exception('实名信息保存失败');
            }

            // todo 若可以修改实名认证  需要删除原有Esign账户
            // 创建esign用户
            $accountid = $esignService->addPerson([
                'mobile' => $this->user->mobile,
                'name' => $truename,
                'idcard' => $idcard
            ]);
            EsignUser::updateOrCreate([
                'userid' => $this->user->id
            ], [
                'accountid' => $accountid
            ]);

            // 用户已通过实名认证
            $this->user->update([
                'vtruename' => 1,
                'truename' => $userRealNameData->truename
            ]);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return responseException($exception->getMessage());
        }

        // 清除缓存
        $this->clearCache();
        return responseMessage(__('api.success'), new UserRealNameResource($userRealNameData));
    }

    /**
     * 取消确认 (删除除id/userid之外的所有字段)
     * @param UserRealNameRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel(UserRealNameRequest $request)
    {
        $userRealNameData = UserRealName::ofUserid($this->user->id)->first();
        if (!$userRealNameData) {
            return responseException(__('api.no_result'));
        }

        foreach ($userRealNameData as $k => $v) {
            if ($k === 'id' || $k === 'userid') {
                continue;
            }
            $userRealNameData[$k] = '';
        }
        // 删除图片
        if ($userRealNameData->face_img) Storage::disk('uploads')->delete($userRealNameData->face_img);
        if ($userRealNameData->back_img) Storage::disk('uploads')->delete($userRealNameData->back_img);

        if (!$userRealNameData->save()) {
            return responseException(__('web.failed'));
        }
        // 清楚缓存
        $this->clearCache();
        return responseMessage(__('api.success'));
    }

    /**
     * 获取个人实名认证 人脸识别地址
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function faceUrlPerson(Request $request)
    {
        $service = new EsignFaceService();
        if (!$this->user->esignUser) {
            $accountId = $service->userCreate($this->user->id);
            EsignUser::create([
               'userid' => $this->user->id,
               'accountid' => $accountId,
               'type' => EsignUser::TYPE_PERSON,
            ]);
        }
        $esignUser = EsignUser::where('userid', $this->user->id)->first();
        $urlData = $service->getFaceUrl($esignUser->accountid);
        return responseMessage(__('api.success'), $urlData);
    }

    public function verifyIdentityResult(Request $request)
    {
    //    1443705839239039013
        $service = new EsignFaceService();
        $data = $service->identityDetail($request->flowId);
        if (strtolower($data['status']) !== 'success') {
            return responseException($data['failReason']);
        }
        $userRealName = UserRealName::firstOrCreate(['userid' => $this->user->id], [

        ]);
        $accountId = $data['indivInfo']['accountId'];
        $esignUser = EsignUser::where('userid', $this->user->id)->first();
    }
    //public function faceUrlCompany(Request $request)
    //{
    //    $service = new EsignFaceService();
    //    if (!$this->user->esignUser) {
    //        $accountId = $service->userCreate($this->user->id);
    //        EsignUser::create([
    //            'userid' => $this->user->id,
    //            'accountid' => $accountId,
    //            'type' => EsignUser::TYPE_PERSON,
    //        ]);
    //    }
    //}
}
