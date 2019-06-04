<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/11/10
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserOauth;
use App\Repositories\HotelRepository;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Messages\Transfer;
use Log;

class WechatController extends Controller
{
    const CHANNEL = 'wechat';

    protected $app;

    public function __construct()
    {
        $this->app = app('wechat.official_account');
    }

    /**
     * 消息处理
     *
     * @return string
     */
    public function serve()
    {
        Log::info('request arrived.');

        //$this->app = app('wechat.official_account');
        $this->app->server->push(function ($message) {
            logger('wechat', $message);
            switch ($message['MsgType']) {
                case 'event':
                    if (isset($message['FromUserName'])) {
                        $this->autoRegister($message['FromUserName']);
                    }
                    return '';
                    break;
                case 'text':
                    return new Transfer();
                case 'image':
                    return new Transfer();
                case 'voice':
                    return new Transfer();
                case 'video':
                    return new Transfer();
                case 'location':
                case 'link':
                case 'file':
                default:
                    return '';
                    break;
            }
        });
        //$message = $app->server->getMessage();
        //if (isset($message['FromUserName'])) {
        //    $user = $app->user->get($message['FromUserName']);
        //    logger('user: ', $user);
        //}

        $response = $this->app->server->serve();
        Log::info($response);
        return $response;
    }

    protected function autoRegister($openid)
    {
        $user = $this->app->user->get($openid);
        logger('user: ', $user);
        $userOauth = UserOauth::where('openid', $openid)->where('channel', self::CHANNEL)->first();
        if (!$userOauth) {
            $insertData = [
                'userid' => 0,
                'openid' => $openid,
                'unionid'=> $user['unionid'],
                'channel'=> self::CHANNEL,
                'client_id'=> 4
            ];
            $userOauth = UserOauth::create($insertData);
            \Log::debug('userOauth insert '. ($userOauth ? 'ok' : 'false'));
        }
        if (!$userOauth->userid) {
            $relationOauth = UserOauth::where('unionid', $user['unionid'])
                ->whereIn('channel', [MiniProgramController::CHANNEL, WechatController::CHANNEL])
                ->where('userid', '<>', 0)
                ->first();
            if ($relationOauth) {
                $userOauth->userid = $relationOauth->userid;
                $userOauth->save();
            }
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|\Illuminate\View\View|mixed
     */
    protected static function userinfo()
    {
        $user = session('wechat.oauth_user.default');
        if (!$user) {
            return self::error('获取用户授权信息失败');
        }
        $user = $user->getOriginal();
        $userOauth = UserOauth::where('openid', $user['openid'])
            ->where('channel', self::CHANNEL)
            ->first();
        \Log::debug('userinfo => ' . var_export($user, true));
        if (!$userOauth) {
            return self::error('用户未注册(1)');
        }
        if (!$userOauth->userid) {
            $userOauth = UserOauth::where('unionid', $userOauth->unionid)
                ->where('channel', MiniProgramController::CHANNEL)
                ->first();
            if (!$userOauth) {
                return self::error('用户未注册小程序(1)');
            }
        }
        $user = User::find($userOauth->userid);
        if (!$user) {
            return self::error('用户未注册小程序(2)');
        }
        return $user;
    }

    /**
     * @param $message
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected static function success($message)
    {
        $data = [
            'title' => __('api.success'),
            'message' => $message
        ];
        return response()->view('wechat.public.success', $data)->send();
    }

    /**
     * @param $message
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected static function error($message)
    {
        $data = [
            'title' => __('api.failed'),
            'message' => $message
        ];
        return response()->view('wechat.public.error', $data)->send();
    }

    protected function login()
    {

    }
}