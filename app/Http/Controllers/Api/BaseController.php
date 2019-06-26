<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/6/16
 * Time: 13:13
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected $user = null;// 当前登录用户
    protected $client_id = null;// 当前客户端id

    public function __construct(\Request $request)
    {
        $user = $request::user('api');
        if ($user) $this->user = $user;
        if ($request::hasHeader('client-id')) {
            $this->client_id = intval($request::header('client-id'));
        }
    }
}