<?php
/**
 * Note: 用户实名
 * tip 图片文件名使用userid, 图片更新后地址不会更新, 浏览器会认为是同一张图片
 * 返回时需要加上rand参数
 * User: Liu
 * Date: 2019/7/1
 */
namespace App\Http\Controllers\Api;

use App\Http\Requests\UserRealNameRequest;
use App\Models\UserRealName;

use App\Http\Resources\UserRealName as UserRealNameResource;
use App\Services\Ocr\IdCardService;
use \DB;

class UserRealNameController extends BaseController
{
    public function index()
    {

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
     * 通过接口查询身份证信息并更新
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

        if (!$userRealNameData->save()) {
            return responseException(__('api.failed'));
        }

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
     * 身份确认
     * @param UserRealNameRequest $request
     * @param UserRealName $userRealName
     * @return \Illuminate\Http\JsonResponse
     */
    public function confirm(UserRealNameRequest $request, UserRealName $userRealName)
    {
        $userRealNameData = $userRealName::ofUserid($this->user->id)->first();
        if (!$userRealNameData) {
            return responseException(__('api.no_result'));
        }
        $truename = $request->input('truename');
        $idcard = $request->input('idcard');
        if (empty($idcard) || empty($truename)) {
            return responseException(__('api.empty_param'));
        }
        // 未变更
        if ($truename === $userRealNameData->truename && $idcard === $userRealNameData->idcard) {
            return responseMessage(__('api.success'));
        }
        $userRealNameData->truename = $truename;
        $userRealNameData->idcard = $idcard;
        if (!$userRealNameData->save()) {
            return responseException(__('api.failed'));
        }
        return responseMessage(__('api.success'));
    }
}