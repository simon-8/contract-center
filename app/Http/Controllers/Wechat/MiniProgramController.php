<?php

namespace App\Http\Controllers\Wechat;
use App\Http\Controllers\Controller;

use EasyWeChat;

class MiniProgramController extends Controller
{
    public function getUser(\Request $request)
    {
        $code = $request::input('code');
        $app = EasyWeChat::miniProgram();
        return $app->auth->session($code);
    }
}