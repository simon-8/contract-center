<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/6/19
 */
namespace App\Http\Controllers\Api;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\LeanCloudService;

class UserController extends BaseController
{

    /**
     * todo 暂时无用
     * @param User $user
     * @return User
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * 用户信息
     * @return \Illuminate\Http\JsonResponse
     */
    public function info()
    {
        return responseMessage('', $this->user);
    }

    /**
     * 发送短信
     * @param UserRequest $request
     * @param LeanCloudService $leanCloudService
     * @return \Illuminate\Http\JsonResponse
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function sendCode(UserRequest $request, LeanCloudService $leanCloudService)
    {
        $data = $request->all();
        $request->validateSendSms($data);

        try {
            $leanCloudService->sendVerifyCode($data['mobile']);
        } catch (\Exception $e) {
            return responseException($e->getMessage());
        }

        return responseMessage(__('api.success'));
    }

    /**
     * 绑定手机
     * @param UserRequest $request
     * @param User $user
     * @param LeanCloudService $leanCloudService
     * @return \Illuminate\Http\JsonResponse
     */
    public function bindMobile(UserRequest $request, User $user, LeanCloudService $leanCloudService)
    {
        $data = $request->all();
        $request->validateVerifyCode($data);

        try {
            $leanCloudService->verifyCode($data['mobile'], $data['code']);
        } catch (\Exception $e) {
            return responseException($e->getMessage());
        }
        $alreadyUse = $user::ofMobile($data['mobile'])->exists();
        if ($alreadyUse) {
            return responseException(__('auth.mobile_already_use'));
        }
        $this->user->mobile = $data['mobile'];
        $this->user->save();

        return responseMessage(__('api.success'));
    }

}