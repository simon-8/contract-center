<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/6/19
 */

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\UserOauth;
use App\Services\AuthService;
use App\Services\SmsService;
use Illuminate\Support\Facades\DB;

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
        $this->user->loadMissing('company');
        return responseMessage('', $this->user);
    }

    /**
     * 发送短信
     * @param UserRequest $request
     * @param SmsService $smsService
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendCode(UserRequest $request, SmsService $smsService)
    {
        $data = $request->all();
        $request->validateSendSms($data);

        try {
            $smsService->sendVerifyCode($data['mobile']);
        } catch (\Exception $e) {
            return responseException($e->getMessage());
        }

        return responseMessage(__('api.success'));
    }

    /**
     * 绑定手机
     * @param UserRequest $request
     * @param User $user
     * @param SmsService $smsService
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function bindMobile(UserRequest $request, User $user, SmsService $smsService)
    {
        $data = $request->all();
        $request->validateVerifyCode($data);

        try {
            $smsService->verifyCode($data['mobile'], $data['code']);
        } catch (\Exception $e) {
            return responseException($e->getMessage());
        }
        $alreadyUser = $user::ofMobile($data['mobile'])->first();
        if ($alreadyUser) {
            if (!$this->needMigrate($alreadyUser)) return responseException(__('auth.mobile_already_use'));
            return $this->migrateWithMobile($alreadyUser);
        } else {
            $this->user->mobile = $data['mobile'];
            $this->user->save();
        }

        return responseMessage(__('api.success'));
    }

    /**
     * 是否需要迁移
     * @param User $user
     * @return bool
     */
    protected function needMigrate(User $user)
    {
        return !password_verify(md5($user->id), $user->password);
    }

    /**
     * 根据手机号迁移
     * @param User $oldUser
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function migrateWithMobile(User $oldUser)
    {
        // 手机号被老用户使用, 进行迁移
        $channels = [
            UserOauth::CHANNEL_WECHAT,
            UserOauth::CHANNEL_WECHAT_MINI,
            UserOauth::CHANNEL_WECHAT_OFFICIAL,
        ];
        $newOauth = $this->user->oauth()
            ->whereIn('channel', $channels)
            ->where('unionid', '>', '')
            ->select('channel', 'unionid', 'openid')
            ->first();

        // 直接更新老oauth的unionid, 下次直接使用unionid登录
        $oldUser->password = md5($oldUser->id);//使用新的密码规则
        $oldUser->save();
        $oldUser->oauth()->whereIn("channel", $channels)->update([
            'unionid' => $newOauth->unionid,
            'openid' => $newOauth->openid,
        ]);
        // 将新oauth的 unionid 与 openid 改为其他
        $this->user->oauth()->update([
            'unionid'  => DB::raw('CONCAT("bak_", `unionid`)'),
            'openid'  => DB::raw('CONCAT("bak_", `openid`)'),
        ]);

        $clientData = \Laravel\Passport\Client::find($oldUser->client_id);
        $authService = new AuthService();
        $token = $authService->passwordToToken([
            'client_id' => $clientData->id,
            'client_secret' => $clientData->secret,
            'username' => $oldUser->id,
            'password' => md5($oldUser->id),
        ]);

        return responseMessage(__('api.success'), compact('token'));
    }

    public function test()
    {
        $user = $this->user->realname;
        dd($user);
    }
}
