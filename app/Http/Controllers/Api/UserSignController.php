<?php
/**
 * Note: 用户签名
 * User: Liu
 * Date: 2019/6/27
 */
namespace App\Http\Controllers\Api;

use App\Models\UserSign;
use App\Http\Resources\UserSign as UserSignResource;

use App\Services\EsignService;

class UserSignController extends BaseController
{
    /**
     * 列表
     * @param UserSign $userSign
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(UserSign $userSign)
    {
        $lists = $userSign->where('userid', $this->user->id)
            ->paginate();
        return UserSignResource::collection($lists);
    }

    /**
     * 保存
     * @param \Request $request
     * @param UserSign $userSign
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(\Request $request, UserSign $userSign)
    {
        $data = $request::only(['contract_id']);
        if (!$request::hasFile('file')) {
            return responseException('请选择文件上传');
        }
        $file = $request::file('file');
        if (!$file->isValid()) {
            return responseException('图片文件无效');
        }
        $result = $file->store('signs/'.date('Ym/d'), 'uploads');
        $data['thumb'] = '/'. $result;
        $data['userid'] = $this->user->id;
        if (!$userSign->create($data)) {
            return responseException(__('api.failed'));
        }
        return responseMessage(__('api.success'));
    }

    /**
     * 更新
     * @param \Request $request
     * @param UserSign $userSign
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(\Request $request, UserSign $userSign)
    {
        if (!$request::hasFile('file')) {
            return responseException('请选择文件上传');
        }
        $file = $request::file('file');
        if (!$file->isValid()) {
            return responseException('图片文件无效');
        }
        $result = $file->store('signs/'.date('Ym/d'), 'uploads');
        $data['thumb'] = '/'. $result;

        if (!$userSign->update($data)) {
            return responseException(__('api.failed'));
        }
        return responseMessage(__('api.success'));
    }

    /**
     * 删除
     * @param UserSign $userSign
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(UserSign $userSign)
    {
        if (!$userSign->delete()) {
            return responseException(__('web.failed'));
        }
        return responseMessage(__('api.failed'));
    }
}