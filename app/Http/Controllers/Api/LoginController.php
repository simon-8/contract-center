<?php
/**
 * Note: *
 * User: Liu
 * Date: 2020/8/22
 * Time: 19:47
 */
namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use App\Models\UserOauth;
use App\Redis\UserRedis;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Overtrue\LaravelSocialite\Socialite;
use Overtrue\Socialite\Config;

class LoginController extends BaseController
{
    /**
     * 微信登录
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function wechat(LoginRequest $request)
    {
        $data = $request->validateWechat();

        try {
            $accessToken = Socialite::driver('wechat')->getAccessToken($request->code);
            $user = Socialite::driver('wechat')->user($accessToken);
        } catch (\Exception $e) {
            info(__METHOD__, [
                'data' => $request->all(),
                'exception' => $e->getMessage(),
            ]);
            return responseException($e->getMessage());
        }

        info(__METHOD__, [$user]);
        // info(__METHOD__, [$user->getOriginal()]);

        if (!empty($user->getOriginal()['errcode'])) return responseException(__('auth.wechat_login_failed'));

        $openid = $user->getOriginal()['openid'];
        $unionid = $user->getOriginal()['unionid'];
        //$relationOauth = UserOauth::whereUnionid($user->getOriginal()['unionid'])->first();
        $userOauth = UserOauth::firstOrCreate([
            'channel' => UserOauth::CHANNEL_WECHAT,
            'unionid' => $unionid,
        ], [
            'client_id' => $this->client_id ?: 0,// header中传递, 可能未传递
            'openid' => $openid,
            'userid' => 0,// 如果有关联用户信息
        ]);

        // 如果没有关联用户时, 先试着根据unionid查找
        if (!$userOauth->userid) {
            if ($userid = UserOauth::getUseridByWechat($unionid)) {
                $userOauth->userid = $userid;
                $userOauth->save();
            }
        }

        if (!$userOauth->userid) {
            $data['password'] = md5($unionid);
            $userData = User::create(array_merge($data, [
                'nickname' => $user->getOriginal()['nickname'],
                'country' => $user->getOriginal()['country'],
                'province' => $user->getOriginal()['province'],
                'city' => $user->getOriginal()['city'],
                'avatar' => $user->getOriginal()['headimgurl'],
            ]));
            if (!$userData) return responseException(__('auth.create_user_failed'), []);
            $userData->password = md5($userData->id);
            $userData->save();

            $userOauth->userid = $userData->id;
            $userOauth->save();
        } else {
            $userData = $userOauth->user;
        }
        logger(__METHOD__, [$userData]);
        logger(__METHOD__, [$userOauth]);
        if (!$userData) return responseException(__('auth.create_user_failed'));

        // 更新同unionid无userid的用户
        if ($unionid) UserOauth::updateUseridByUnionid($unionid, $userData->id, UserOauth::getWechatChannels());

        // 使用id做为密码
        $authService = new AuthService();
        $user = $authService->loginWithOauth($userData, array_merge($data, ['password' => md5($userData->id)]));
        return responseMessage('', $user);
    }
}
