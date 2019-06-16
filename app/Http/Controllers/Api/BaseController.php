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
    protected $user = null;

    public function __construct(\Request $request)
    {
        $user = $request::user('api');
        if ($user) $this->user = $user;
    }
}