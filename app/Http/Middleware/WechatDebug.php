<?php

namespace App\Http\Middleware;

use Closure;
use Overtrue\Socialite\User as SocialiteUser;

class WechatDebug
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (config('app.debug')) {
            $user = [
                'openid' => 'o3cy20_KtWLnIEGC6h-wBPsX521M',
                'nickname' => '刘文静',
                'headimgurl' => 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83eruqaxH6bnFLNuGdJm4XsLV6oufsbeba2fXsZcjkKcxbSMRtX7QDlTfzhCFGwGcAyGibhibozyWcO4Q/132',
            ];
            $user = new SocialiteUser([
                'id' => array_get($user, 'openid'),
                'name' => array_get($user, 'nickname'),
                'nickname' => array_get($user, 'nickname'),
                'avatar' => array_get($user, 'headimgurl'),
                'email' => null,
                'original' => $user,
                'provider' => 'WeChat',
            ]);
            session(['wechat.oauth_user.default' => $user]);
        }
        return $next($request);
    }
}
