<?php

namespace App\Http\Controllers\Wechat;
use App\Http\Controllers\ApiController;

use EasyWeChat;

class MiniProgramController extends ApiController
{
    /**
     * 获取用户openid
     * @param \Request $request
     * @return \Illuminate\Http\Response
     */
    public function getUser(\Request $request)
    {
        if (!$request::has('code')) {
            return self::error('参数缺失');
        }
        $code = $request::input('code');
        $app = EasyWeChat::miniProgram();
        try {
            $result = $app->auth->session($code);
            if (!empty($result['errmsg'])) {
                return self::error($result['errmsg'], $result['errcode']);
            }
            return self::response($result);
        } catch (\Exception $exception) {
            return self::error($exception->getMessage(), $exception->getCode());
        }
    }
}