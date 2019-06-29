<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/6/27
 * Time: 23:11
 */
namespace App\Http\Controllers\Api;

use App\Http\Requests\UserAddressRequest;
use App\Models\UserAddress;
use App\Http\Resources\UserAddress as UserAddressResource;
use \DB;

class UserAddressController extends BaseController
{
    /**
     * 列表
     * @param UserAddress $userAddress
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(UserAddress $userAddress)
    {
        $lists = $userAddress->where('userid', $this->user->id)
            ->paginate();
        return UserAddressResource::collection($lists);
    }

    /**
     * 详情
     * @param UserAddress $userAddress
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(UserAddress $userAddress)
    {
        return responseMessage('', new UserAddressResource($userAddress));
    }

    /**
     * 保存
     * @param UserAddressRequest $request
     * @param UserAddress $userAddress
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserAddressRequest $request, UserAddress $userAddress)
    {
        $data = $request->all();
        $request->validateStore($data);

        $data['userid'] = $this->user->id;
        if (!$userAddress->create($data)) {
            return responseException(__('web.failed'));
        }
        return responseMessage(__('web.success'));
    }

    /**
     * 更新
     * @param \Request $request
     * @param UserAddress $userAddress
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(\Request $request, UserAddress $userAddress)
    {
        $this->checkAuth($userAddress);

        $data = $request::all();
        if (!$userAddress->update($data)) {
            return responseException(__('web.failed'));
        }
        return responseMessage(__('web.success'));
    }

    /**
     * 删除
     * @param UserAddress $userAddress
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(UserAddress $userAddress)
    {
        $this->checkAuth($userAddress);

        if (!$userAddress->delete()) {
            return responseException(__('web.failed'));
        }
        return responseMessage(__('web.success'));
    }

    /**
     * 权限检查
     * @param $userAddress
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function checkAuth($userAddress)
    {
        if ($userAddress->userid != $this->user->id) {
            return responseException(__('api.no_auth'));
        }
        return true;
    }
}