<?php
/**
 * Note: 后台控制器基类
 * User: Liu
 * Date: 2018/4/4
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Repositories\RoleAccessRepository;
use App\Models\Manager;
use App\Repositories\MenuRepository;

class BaseController extends Controller
{
    // 权限测试 菜单测试
    public function __construct(RoleAccessRepository $roleAccessRepository, Manager $manager, MenuRepository $menuRepository)
    {
        $roles = $manager->find(2)->getRoles()->where('status', 1)->get();
        $access = [];
        foreach ($roles as $role) {
            $access = array_merge($access, $role->getAccess->toArray());
        }
        $access = collect($access)->sortBy('route');
        $routes = array_column($access->toArray(), 'route');

        $currentRouteName = \Route::currentRouteName();

        $array_match = function($val, $array) {
            $cross = false;
            if (array_search($val, $array) !== false) {
                $cross = true;
            }
            if (!$cross) {
                foreach ($array as $value) {
                    if (substr($val, 0, strlen($value)) === $value) {
                        $cross = true;
                    }
                }
            }
            return $cross;
        };
        $cross = $array_match($currentRouteName, $routes);
        if (!$cross) {
            echo '没有权限';
            //\Log::debug('没有权限');
        }

        // 菜单测试
        $menus = $menuRepository->lists();
        $myMenus = [];
        foreach ($menus as $k => $menu) {
            if (empty($menu['child'])) {
                if ($menu['route']) {
                    if ($array_match($menu['route'], $routes)) {
                        $myMenus[$k] = $menu;
                    }
                } else {
                    $myMenus[$k] = $menu;
                }
                continue;
            }

            foreach ($menu['child'] as $ck => $cmenu) {
                if ($cmenu['route']) {
                    if ($array_match($cmenu['route'], $routes)) {
                        $myMenus[$k]['child'][$ck] = $cmenu;
                        continue;
                    }
                }
                unset($menu['child'][$ck]);
            }
            if (!empty($menu['child'])) {
                $myMenus[$k] = $menu;
            }
        }
        dd($myMenus);
    }
}