<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/11/11
 * Time: 16:21
 */
namespace App\Services;
//use App\Models\RoleAccess;
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
            'login',
            'logout',
            'index',
            'log-viewer',
            'horizon',
            'database',
            'ajax',
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
        $user->tokens->each(function ($token) use ($clientId) {
            if ($token->client_id == $clientId) {
                $token->delete();
            }
        });
    }
}