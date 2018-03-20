<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/3/20
 * Time: 22:42
 */
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    /**
     * 错误
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\Response
     */
    public static function error($message = "操作异常", $code = 422)
    {
        return \Response::make([
            'message'     => $message,
            'code' => $code,
        ], 422);
    }

    /**
     * 成功
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\Response
     */
    public static function success($message = "操作成功", $code = 200)
    {
        return \Response::make([
            'message'     => $message,
            'code' => $code,
        ], 200);
    }
}