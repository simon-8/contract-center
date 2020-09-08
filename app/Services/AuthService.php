<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/11/11
 * Time: 16:21
 */
namespace App\Services;
//use App\Models\RoleAccess;
use App\Models\Manager;
use App\Models\Menu;
use App\Models\Role;
use App\Models\User;

class AuthService
{
    public static $errmsg = '';

    /**
     * 不要权限就能访问的组
     * @return array
     */
    public function getIgnorePermissionGroups()
    {
        return [
            'admin.login',
            'admin.logout',
            'admin.index',
            //'log-viewer',
            //'horizon',
            //'database',
            'admin.ajax',
        ];
    }

    /**
     * 不要权限就能访问的页面
     * @return array
     */
    //public function getIgnorePermissions()
    //{
    //    return [
    //        'admin.dashboard.index',
    //        'admin.upload_to_tester',
    //        'admin.login',
    //        'admin.index',
    //        'admin.logout',
    //        'admin.merchant.index'
    //    ];
    //}

    public function getRoles()
    {
        return Role::where('status', 1)->get()->all();
    }

    /**
     * 获取路由
     * @param bool $ignore
     * @return \Illuminate\Config\Repository|mixed
     */
    public function getRoutes($ignore = true)
    {
        $routes = config('menus');
        //$routes = \Route::getRoutes()->getRoutesByName();
        $ingnoreGroups = $ignore ? $this->getIgnorePermissionGroups() : [];
        foreach ($routes as $route => $name) {
            foreach ($ingnoreGroups as $group) {
                if (\Str::startsWith($route, $group)) {
                    unset($routes[$route]);
                }
            }
        }
        return $routes;
    }

    /**
     * 权限检查
     * @param $user
     * @return bool
     */
    public function checkPermission(Manager $user)
    {
        $routes = [];
        foreach ($user->roles as $role) {
            $routes = array_merge($routes, $role->roleAccess->pluck('route')->all());
        }

        if (array_search('*', $routes) !== false) {
            return true;
        }
        $currentRoute = \Route::currentRouteName();

        $continue = false;
        foreach ($routes as $route) {
            // 精确路由
            if (strpos($route, '.') !== false) {
                if (\Str::startsWith($currentRoute, $route)) {
                    $continue = true;
                    break;
                }
            } else {
                if (\Str::startsWith($currentRoute, $route .'.')) {
                    $continue = true;
                    break;
                }
            }
        }
        return $continue;
    }

    /**
     * 获取菜单
     * @return array
     */
    public function getMenus()
    {
        $user = \Request::user('admin');
        $menus = (new Menu())->getMenus();

        $routes = $myMenus = [];
        foreach ($user->roles as $role) {
            $routes = array_merge($routes, $role->roleAccess->pluck('route')->all());
        }
        if (array_search('*', $routes) !== false) {
            return $menus;
        }
//dd($menus, $routes);
        foreach ($menus as $k => $menu) {
            // 路由权限判断
            if (empty($menu['child'])) {
                if ($menu['route']) {
                    // 拥有*权限
                    $prefix = substr($menu['route'], 0, strrpos($menu['route'], '.'));
                    if ($prefix && array_search_value($prefix.'.*', $routes)) {
                        $myMenus[$k] = $menu;
                        continue;
                    }
                    if (array_search_value($menu['route'], $routes)) {
                        $myMenus[$k] = $menu;
                    }
                } else {
                    $myMenus[$k] = $menu;
                }
                continue;
            }
            if (strpos($menu['route'], '*') !== false && array_search_value($menu['route'], $routes)) {
                $myMenus[$k] = $menu;
                continue;
            }
            foreach ($menu['child'] as $ck => $cmenu) {
                // 路由权限判断
                if ($cmenu['route']) {
                    // 拥有*权限
                    $prefix = substr($cmenu['route'], 0, strrpos($cmenu['route'], '.'));
                    if ($prefix && array_search_value($prefix.'.*', $routes)) {
                        $menu['child'][$ck] = $cmenu;
                        continue;
                    }
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

    /**
     * 密码授权令牌
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function passwordToToken($data)
    {
        $requestData = [
            'grant_type' => 'password',
            'client_id' => $data['client_id'],
            'client_secret' => $data['client_secret'],
            'username' => $data['username'],
            'password' => $data['password'],
            'scope' => ''
        ];

        $http = new \GuzzleHttp\Client();
        $response = $http->post(config('app.url') . '/oauth/token', [
            'form_params' => $requestData,
        ]);

        $response = json_decode((string)$response->getBody(), true);

        if (empty($response) || empty($response['access_token'])) {
            throw new \Exception('获取token失败');
        }

        unset($response['refresh_token']);
        return $response;
    }

    /**
     * 移除旧Token
     * @param User $user
     * @param $clientId
     */
    public function removeToken(User $user, $clientId)
    {
        $user->tokens()->where('client_id', $clientId)->delete();
    }

    /**
     * 使用 oauth 登录
     * @param User $user
     * @param array $data
     * @return User|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function loginWithOauth(User $user, array $data)
    {
        if (empty($data['password'])) throw new \Exception('参数缺失: password');

        $clientSecret = getClientSecret($user['client_id']);

        $data['username'] = $user->id;
        $data['client_id'] = $user->client_id;
        $data['client_secret'] = $clientSecret;
        try {
            //(new AuthService())->removeToken($userData, $data['client_id']);
            $user->token = (new AuthService())->passwordToToken($data);
        } catch (\Exception $e) {
            return responseException($e->getMessage());
        }

        $user->loadMissing('company');
        return $user;
    }
}
