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
use \DB;

class UserRealNameController extends BaseController
{
    public function index()
    {

    }

    /**
     * 保存
     * @param UserRealNameRequest $request
     * @param UserRealName $userRealName
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UserRealNameRequest $request, UserRealName $userRealName)
    {
        $data = $request->all();
        $request->validateStore($data);

        // todo 增加判断
        $faceUrl = $request->file('face_img');
        $result = $faceUrl->store('idcards/' . date('Ym/d'), 'uploads');
        $data['face_img'] = '/' . $result;

        $backUrl = $request->file('back_img');
        $result = $backUrl->store('idcards/' . date('Ym/d'), 'uploads');
        $data['back_img'] = '/' . $result;

        $data['userid'] = $this->user->id;

        if (!$userRealName->create($data)) {
            return responseException(__('api.failed'));
        }
        return responseMessage(__('api.success'));
    }

    /**
     * 更新
     * @param UserRealNameRequest $request
     * @param UserRealName $userRealName
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(UserRealNameRequest $request, UserRealName $userRealName)
    {
        $data = $request->all();
        $request->validateUpdate($data);

        $userRealNameData = $userRealName::ofUserid($this->user->id);
        // todo 删除原图片
        $faceUrl = $request->file('face_img');
        $result = $faceUrl->store('idcards/' . date('Ym/d'), 'uploads');
        $data['face_img'] = '/' . $result;

        $backUrl = $request->file('back_img');
        $result = $backUrl->store('idcards/' . date('Ym/d'), 'uploads');
        $data['back_img'] = '/' . $result;

        if (!$userRealNameData->update($data)) {
            return responseException(__('api.failed'));
        }
        return responseMessage(__('api.success'));
    }

    /**
     * 删除
     * @param UserRealName $userRealName
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(UserRealName $userRealName)
    {
        $userRealNameData = $userRealName::ofUserid($this->user->id);

        if (!$userRealNameData->delete()) {
            return responseException(__('web.failed'));
        }
        return responseMessage(__('api.success'));
    }
}