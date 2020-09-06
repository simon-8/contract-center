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
            // 同一个unionid且有用户ID的关联数据
            $relationOauth = UserOauth::whereUnionid($unionid)
                ->where('userid', '>', 0)
                ->whereIn('channel', [
                    UserOauth::CHANNEL_WECHAT_MINI,
                    UserOauth::CHANNEL_WECHAT_OFFICIAL,
                ])
                ->first();
            if ($relationOauth) {
                $userOauth->userid = $relationOauth->userid;
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
            $userOauth->userid = $userData->id;
            $userOauth->save();
        } else {
            $userData = $userOauth->user;
        }
        logger(__METHOD__, [$userData]);
        logger(__METHOD__, [$userOauth]);
        if (!$userData) return responseException(__('auth.create_user_failed'));

        // 更新同unionid无userid的用户
        UserOauth::whereUnionid($unionid)
            ->whereIn('channel', [
                UserOauth::CHANNEL_WECHAT_MINI,
                UserOauth::CHANNEL_WECHAT_OFFICIAL,
            ])
            ->where('userid', 0)
            ->update([
                'userid' => $userData->id,
            ]);

        // 使用unionid做为密码
        return $this->loginWithOauth($userData, array_merge($data, ['password' => md5($unionid)]));
    }

    /**
     * 使用 oauth 登录
     * @param User $user
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    protected function loginWithOauth(User $user, array $data)
    {
        if (empty($data['password'])) throw new \Exception('参数缺失: password');

        $clientSecret = Cache::remember('client'.$user['client_id'], now()->addDay(), function() use ($user) {
            return \Laravel\Passport\Client::find($user['client_id'])->getOriginal('secret');
        });

        $data['username'] = $user->id;
        $data['client_id'] = $user->client_id;
        $data['client_secret'] = $clientSecret;
        try {
            //(new AuthService())->removeToken($userData, $data['client_id']);
            $user->token = (new AuthService())->passwordToToken($data);
        } catch (\Exception $e) {
            return responseException($e->getMessage());
        }

        $user->loadMissing('company');
        return responseMessage('', $user);
    }
}
