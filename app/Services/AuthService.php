<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/6/15
 */
namespace App\Services;

use App\Repositories\MenuRepository;
use App\Models\AdminLogs;
use App\Models\Manager;
use App\Models\User;

class  AuthService
{
    protected static $errmsg = '';

    public function getError()
    {
        return self::$errmsg;
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
            $routes = array_merge($routes, array_column($role->roleAccess->toArray(), 'route'));
        }

        if (array_search('*', $routes) !== false) {
            return true;
        }
        $currentRoute = \Route::currentRouteName();

        $continue = false;
        foreach ($routes as $route) {
            // 精确路由
            if (strpos($route, '.') !== false) {
                if (starts_with($currentRoute, $route)) {
                    $continue = true;
                    break;
                }
            } else {
                if (starts_with($currentRoute, $route .'.')) {
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
        $menus = (new MenuRepository())->getMenus();

        $routes = $myMenus = [];
        foreach ($user->roles as $role) {
            $routes = array_merge($routes, array_column($role->roleAccess->toArray(), 'route'));
        }

        if (array_search('*', $routes) !== false) {
            return $menus;
        }

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

    /**
     * @param User $user
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function getAccessToken(User $user, $data)
    {
        self::$errmsg = '';

        $cacheKey = 'access_token:' . $data['client_id'] . ':' . $user->id;

        //\Cache::forget($cacheKey);
        $tokenData = \Cache::remember($cacheKey, config('api.expire_token'), function () use ($user, $data) {

            $user->tokens->each(function ($token) use ($data) {
                if ($token->client_id == $data['client_id']) {
                    $token->delete();
                }
            });

            $requestData = [
                'grant_type' => 'password',
                'client_id' => $data['client_id'],
                'client_secret' => $data['client_secret'],
                'username' => $data['username'],
                'password' => $data['password'],
                'scope' => ''
            ];

            try {
                $api = config('app.url') . '/oauth/token';
                $response = mpost($api, $requestData);
                $response = json_decode($response, true);
            } catch (\Exception $exception) {
                self::$errmsg = $exception->getMessage();
                return false;
            }

            if (empty($response) || empty($response['access_token'])) {
                self::$errmsg = '获取token失败';
                return false;
            }

            return $response;
        });

        if (!$tokenData) {
            throw new \Exception(self::$errmsg);
        }

        unset($tokenData['refresh_token']);
        return $tokenData;
    }

    /**
     * 保存log
     * @param $event
     * @param $data
     */
    public static function setLogs($event, $data)
    {
        $adminLogs = new AdminLogs();
        $adminLogs->userid = auth('admin')->user()->id;
        $adminLogs->event = $event;
        $adminLogs->data = is_array($data) ? var_export($data, true) : $data;
        $adminLogs->ip = \Request::ip();
        $adminLogs->save();
    }
}