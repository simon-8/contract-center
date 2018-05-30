<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/5/29
 */
namespace App\Services;
use App\Repositories\ManagerRepository;
use App\Repositories\MenuRepository;

class AuthService
{
    private static $accessKeyPrefix = 'userAccess';

    /**
     * 用户权限缓存名称
     * @param $userid
     * @return string
     */
    public function getUserAccessKey($userid)
    {
        $userAccessKey = self::$accessKeyPrefix.$userid;
        return $userAccessKey;
    }

    /**
     * 查询用户权限路由
     * @param $userid
     * @return array
     */
    public function queryRoutes($userid)
    {
        $managerRepository = new ManagerRepository();

        $user = $managerRepository->find($userid);
        $roles = $user->getRoles()->where('status', 1)->get();
        $access = [];
        foreach ($roles as $role) {
            $access = array_merge($access, $role->getAccess->toArray());
        }
        $access = collect($access)->sortBy('route');
        $routes = array_column($access->toArray(), 'route');

        return $routes;
    }

    /**
     * 获取用户权限路由
     * @param $userid
     * @return mixed
     */
    public function getUserRoutes($userid)
    {
        $userAccessKey = $this->getUserAccessKey($userid);

        $routes = \Cache::rememberForever($userAccessKey, function() use ($userid) {
            return $this->queryRoutes($userid);
        });
        return $routes;
    }

    /**
     * 缓存用户权限路由
     * @param $userid
     * @return bool
     */
    public function setUserRoutes($userid)
    {
        $userAccessKey = $this->getUserAccessKey($userid);
        \Cache::forever($userAccessKey, $this->queryRoutes($userid));
        return true;
    }

    /**
     * 获取拥有权限的菜单
     * @param $userid
     * @return array
     */
    public function getRoleMenus($userid)
    {
        $routes = $this->getUserRoutes($userid);

        $menuRepository = new MenuRepository();
        $menus = $menuRepository->lists();
        $myMenus = [];
        foreach ($menus as $k => $menu) {
            if (empty($menu['child'])) {
                if ($menu['route']) {
                    if (array_search_value($menu['route'], $routes)) {
                        $myMenus[$k] = $menu;
                    }
                } else {
                    $myMenus[$k] = $menu;
                }
                continue;
            }

            foreach ($menu['child'] as $ck => $cmenu) {
                if ($cmenu['route']) {
                    if (array_search_value($cmenu['route'], $routes)) {
                        $menu['child'][$ck] = $cmenu;
                        continue;
                    }
                } else {
                    $menu['child'][$ck] = $cmenu;
                    continue;
                }
                unset($menu['child'][$ck]);
            }
            if (!empty($menu['child'])) {
                $myMenus[$k] = $menu;
            }
        }
        return $myMenus;
    }
}