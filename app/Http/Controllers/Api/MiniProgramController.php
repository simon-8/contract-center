<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/11/14
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserOauth;
use App\Redis\UserRedis;
use App\Services\AuthService;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Crypt;
use App\Http\Resources\User AS UserResource;

class MiniProgramController extends Controller
{
    protected $app;

    public function __construct(\Request $request)
    {
        $this->app = app('wechat.mini_program');
    }

    /**
     * @param \Request $request
     * @param UserOauth $userOauth
     * @param User $user
     * @param AuthService $authService
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(\Request $request, UserOauth $userOauth, User $user, AuthService $authService)
    {
        $code = $request::input('code');
        $data['client_id'] = $request::input('client_id');
        $data['client_secret'] = $request::input('client_secret');
        $data['avatar'] = $request::input('avatarUrl', '');
        $data['nickname'] = $request::input('nickName', '');
        $data['city'] = $request::input('city', '');
        $data['province'] = $request::input('province', '');
        $data['country'] = $request::input('country', 0);
        $data['last_login_time'] = date('Y-m-d H:i:s');

        \Log::info(var_export($data, true));
        if (empty($code)) {
            return responseException('code is missing');
        }
        //Validate client
        if (!verifyPassportClient($data['client_id'], $data['client_secret'])) {
            return responseException(__('auth.client_secret_failed'));
        }

        $response = $this->app->auth->session($code);
        if (!$response) {
            return responseException(__('auth.get_userinfo_failed'), []);
        }
        if (isset($response['errcode']) && $response['errcode'] != 0) {
            return responseException(__('auth.get_userinfo_failed2'). $response['errmsg'], []);
        }
        // debug
        //$response = [
        //    'openid' => $request::input('openid'),
        //    'unionid' => $request::input('unionid'),
        //    'session_key' => '',
        //];
        \Log::info(var_export($response, true));
        $openid = $response['openid'];
        $unionid = $response['unionid'] ?? '';
        $sessionKey = $response['session_key'];

        // 没有unionid时尝试根据iv + encryptedData 解出unionid
        if (!$unionid) {
            $iv = $request::input('iv', '');
            $encryptedData = $request::input('encryptedData', '');
            if ($iv && $encryptedData) {
                $decryptedData = $this->app->encryptor->decryptData($sessionKey, $iv, $encryptedData);
                info($decryptedData);
                $unionid = $decryptedData['unionId'];
                if (!$unionid) {
                    return responseException(__('api.mini_program_no_join_open_platform'));
                }
            }
        }

        // 记录openid信息
        $oauthData = UserOauth::firstOrCreate([
            'channel' => UserOauth::CHANNEL_WECHAT_MINI,
            'openid' => $openid,
        ], [
            'userid' => 0,
            'unionid'=> $unionid,
            'client_id'=> $data['client_id']
        ]);

        // 老用户, 当时没有unionid, 新用户都有unionid
        $oldUser = false;
        if (!$oauthData->unionid) {
            $oldUser = true;
            $oauthData->unionid = $unionid;
        }

        // 根据同unionid已关联微信账号userid进行绑定
        if (!$oauthData->userid && $unionid) {
            if ($userid = UserOauth::getUseridByWechat($unionid)) {
                $oauthData->userid = $userid;
            }
        }

        if (!$oauthData->userid) {
            $data['password'] = md5($unionid);

            $userData = $user->create($data);
            if (!$userData) return responseException(__('auth.create_user_failed'), []);

            $oauthData->userid = $userData->id;

            // 更新同unionid无userid的用户
            if ($unionid) {
                $userOauth->where('unionid', $unionid)
                    ->whereIn('channel', [
                        UserOauth::CHANNEL_WECHAT,
                        UserOauth::CHANNEL_WECHAT_MINI,
                        UserOauth::CHANNEL_WECHAT_OFFICIAL,
                    ])
                    ->where('userid', 0)->update(['userid' => $userData->id]);
            }

        } else {
            $userData = $oauthData->user;
            // 有userid但无user数据 异常数据
            if (!$userData) {
                return responseException(__('auth.get_userinfo_exception'), []);
            }
            $userData->avatar = $data['avatar'];
            $userData->nickname = $data['nickname'];
            $userData->last_login_time = $data['last_login_time'];
            // todo 老用户更新密码
            if ($oldUser) $userData->password = md5($unionid);
        }
        if ($oauthData->isDirty()) $oauthData->save();
        if ($userData->isDirty()) $userData->save();

        // 登录
        $userData = $authService->loginWithOauth($userData, ['password' => md5($unionid)]);

        // 保存session_key到redis
        $redisInsertData = [
            'id' => $userData->id,
            'session_key' => $sessionKey
        ];
        UserRedis::update($redisInsertData);

        return responseMessage('', $userData);
    }

    /**
     * 本地调试使用登录  debug-login/{userid}
     * @param \Request $request
     * @param UserOauth $userOauth
     * @param User $user
     * @param AuthService $authService
     * @param $userid
     * @return \Illuminate\Http\JsonResponse
     */
    public function debugLogin(\Request $request, UserOauth $userOauth, User $user, AuthService $authService, $userid)
    {
        $userData = $user->find($userid);
        if (!$userData) {
            return responseException(__('api.no_result'));
        }
        $oauthData = $userOauth->where('channel', UserOauth::CHANNEL_WECHAT_MINI)->where('userid', $userData->id)->first();
        //$authService->removeToken($user, $userOauth->client_id);

        $client = \Laravel\Passport\Client::findOrFail($oauthData->client_id);
        $data['client_id'] = $oauthData->client_id;
        $data['client_secret'] = $client->secret;
        $data['username'] = $userData->id;
        $data['password'] = md5($oauthData->openid);
        try {
            $token = $authService->passwordToToken($data);
        } catch (\Exception $e) {
            return responseException($e->getMessage());
        }

        //UserService::addCredit($user, 'login');
        return responseMessage('', $token);
    }

    /**
     * 生成小程序二维码
     * @param \Request $request
     * @return string
     */
    public function getUnlimitQrCode(\Request $request)
    {
        $page = $request::input('page');
        $scene = $request::input('scene');
        $width = $request::input('width', 200);
        $response = $this->app->app_code->getUnlimit($scene, [
            'width' => $width,
            'page'  => $page,
        ]);

        if ($response instanceof \EasyWeChat\Kernel\Http\StreamResponse) {
            return $response->getBodyContents();
        }
        return '';
    }

    /**
     * 配置文件
     * @return \Illuminate\Http\JsonResponse
     */
    public function config()
    {
        return responseMessage('', [
            'service_phone' => '123456'
        ]);
    }

    /**
     * 解密数据
     * @param \Request $request
     * @return mixed
     */
    public function decryptData(\Request $request)
    {
        $user = $request::user();
        $iv = $request::input('iv');
        $encryptedData = $request::input('encryptedData');
        $userRedisData = UserRedis::find($user->id);
        $sessionKey = $userRedisData['session_key'];

        $decryptedData = $this->app->encryptor->decryptData($sessionKey, $iv, $encryptedData);
        return $decryptedData;
    }
}
