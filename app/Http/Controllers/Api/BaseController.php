<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/6/16
 * Time: 13:13
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

/**
 *  @property User $user
 *
 * */
class BaseController extends Controller
{
    protected $user = null;// 当前登录用户
    protected $client_id = null;// 当前客户端id

    public function __construct(\Request $request)
    {
        if ($request::hasHeader('Authorization')) {
            $user = $request::user('api');
            if ($user) $this->user = $user;
        }
        if ($request::hasHeader('client-id')) {
            $this->client_id = intval($request::header('client-id'));
        }
    }

    /**
     * 获取用户openid
     * @return string
     */
    public function getOpenid()
    {
        $openid = '';
        if ($this->client_id === User::CLIENT_ID_MINI_PROGRAM) {
            $openid = $this->user->miniGameOpenid();
        } else if ($this->client_id === User::CLIENT_ID_WECHAT) {
            $openid = $this->user->wechatOpenid();
        } else if ($this->client_id === User::CLIENT_ID_WECHAT_APP) {
            $openid = $this->user->wechatAppOpenid();
        }
        return $openid;
    }
}
