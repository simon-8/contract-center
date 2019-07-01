<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/7/1
 */
namespace App\Http\Controllers\Api;

//use App\Http\Resources\Contract AS ContractResource;
//use App\Models\Contract;
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

        \Log::debug(__METHOD__, $data);

        if ($request->hasFile('face_img')) {
            $faceUrl = $request->file('face_img');
            $result = $faceUrl->store('idcards/' . date('Ym/d'), 'uploads');
            $data['face_img'] = '/' . $result;
        }

        if ($request->hasFile('back_img')) {
            $backUrl = $request->file('back_img');
            $result = $backUrl->store('idcards/' . date('Ym/d'), 'uploads');
            $data['back_img'] = '/' . $result;
        }

        $userRealNameData = $userRealName::ofUserid($this->user->id)->first();
        dd($userRealNameData);
        if ($userRealNameData) {
            $userRealNameData = $userRealNameData->update($data);
        } else {
            $data['userid'] = $this->user->id;
            $userRealNameData = $userRealName->create($data);
        }

        if (!$userRealNameData) {
            return responseException(__('api.failed'));
        }
        return responseMessage('', new UserRealNameResource($userRealNameData));
    }

    /**
     * 更新
     * @param UserRealName $userRealName
     * @param IdCardService $idCardService
     * @throws \Exception
     */
    public function update(UserRealName $userRealName, IdCardService $idCardService)
    {
        $userRealNameData = $userRealName::ofUserid($this->user->id);

        $faceImgPath = config('filesystems.disks.uploads.root'). $userRealNameData->face_img;
        $idInfo = $idCardService->getData($faceImgPath, 'face');

        $backImgPath = config('filesystems.disks.uploads.root'). $userRealNameData->back_img;
        $idBackInfo = $idCardService->getData($backImgPath, 'back');

        if ($idInfo['success']) {
            $userRealNameData->truename  = $idInfo['name'];
            $userRealNameData->nationality  = $idInfo['nationality'];
            $userRealNameData->idcard  = $idInfo['num'];
            $userRealNameData->sex  = $idInfo['sex'];
            $userRealNameData->birth  = $idInfo['birth'];
            $userRealNameData->address  = $idInfo['address'];
        }

        if ($idBackInfo['success']) {
            $userRealNameData->start_date  = $idBackInfo['start_date'];
            $userRealNameData->end_date  = $idBackInfo['end_date'];
            $userRealNameData->issue  = $idBackInfo['issue'];
        }

        if (!$userRealNameData->save()) {
            return responseException(__('api.failed'));
        }

        return responseMessage();
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
}