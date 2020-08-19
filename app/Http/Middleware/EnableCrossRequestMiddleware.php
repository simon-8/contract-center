<?php

namespace App\Http\Middleware;

use Closure;

class EnableCrossRequestMiddleware
{
    public function handle($request, Closure $next)
    {
        header('Content-Type: text/html;charset=utf-8');
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:POST,GET,PUT,OPTIONS,DELETE'); // 允许请求的类型
        header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
        header('Access-Control-Allow-Headers: *'); // 设置允许自定义请求头的字段

        return $next($request);

    }
}
