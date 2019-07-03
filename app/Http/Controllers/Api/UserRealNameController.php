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
use App\Services\EsignService;
use App\Services\Ocr\IdCardService;
use \DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

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
        return 'idcards/'. ($this->user->id%10);
    }

    /**
     * 保存 兼并 更新
     * @param UserRealNameRequest $request
     * @param UserRealName $userRealName
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UserRealNameRequest $request, UserRealName $userRealName)
    {
        $data = $request->all();
        $request->validateStore($data);

        // 使用userid作为文件名 更新时可直接覆盖
        if ($request->hasFile('face_img')) {
            $faceUrl = $request->file('face_img');
            $filename = $this->user->id .'.'. $faceUrl->extension();
            $result = $faceUrl->storeAs($this->makeStoreDir(), $filename, 'uploads');
            $data['face_img'] = '/' . $result;
        }

        // 使用userid作为文件名 更新时可直接覆盖
        if ($request->hasFile('back_img')) {
            $backUrl = $request->file('back_img');
            $filename = $this->user->id .'_1.'. $backUrl->extension();
            $result = $backUrl->storeAs($this->makeStoreDir(), $filename, 'uploads');
            $data['back_img'] = '/' . $result;
        }
        $data['userid'] = $this->user->id;

        $w = [
            'userid' => $this->user->id
        ];
        $userRealNameData = $userRealName::updateOrCreate($w, $data);

        if (!$userRealNameData) {
            return responseException(__('api.failed'));
        }
        return responseMessage('', new UserRealNameResource($userRealNameData));
    }

    /**
     * 通过接口查询身份证信息并缓存查询到的信息
     * @param UserRealName $userRealName
     * @param IdCardService $idCardService
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRealName $userRealName, IdCardService $idCardService)
    {
        $userRealNameData = $userRealName::ofUserid($this->user->id)->first();

        // 查询身份证正面数据
        $faceImgPath = config('filesystems.disks.uploads.root'). $userRealNameData->face_img;
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

        // 查询身份证反面数据
        $backImgPath = config('filesystems.disks.uploads.root'). $userRealNameData->back_img;
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
            if (!$userRealNameData->save()) {
                throw new \Exception('保存失败');
            }

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

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return responseException($exception->getMessage());
        }

        // 清除缓存
        $this->clearCache();
        return responseMessage(__('api.success'));
    }

    /**
     * 取消确认 (删除除id/userid之外的所有字段)
     * @param UserRealNameRequest $request
     * @param UserRealName $userRealName
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel(UserRealNameRequest $request, UserRealName $userRealName)
    {
        $userRealNameData = $userRealName::ofUserid($this->user->id)->first();
        if (!$userRealNameData) {
            return responseException(__('api.no_result'));
        }

        foreach ($userRealNameData as $k => $v) {
            if ($k === 'id' || $k === 'userid') {
                continue;
            }
            $userRealNameData[$k] = '';
        }
        if (!$userRealNameData->save()) {
            return responseException(__('web.failed'));
        }
        // 清楚缓存
        $this->clearCache();
        return responseMessage(__('api.success'));
    }
}