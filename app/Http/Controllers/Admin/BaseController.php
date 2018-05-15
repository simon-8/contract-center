<?php
/**
 * Note: 后台控制器基类
 * User: Liu
 * Date: 2018/4/4
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Repositories\RoleAccessRepository;

class BaseController extends Controller
{
    // 权限测试
    public function __construct(RoleAccessRepository $roleAccessRepository)
    {
        $myAccess = $roleAccessRepository->find([2, 3, 4, 5, 6]);
        if (empty($myAccess)) return true;
        $myRoutes = array_column($myAccess->toArray(), 'path');
        $currentRouteName = \Route::currentRouteName();
        if (array_search($currentRouteName, $myRoutes) !== false) {
            return true;
        }

        foreach ($myRoutes as $route) {
            if (substr($currentRouteName, 0, strlen($route)) === $route) {
                return true;
            }
        }
    }
}