<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/3/11
 * Time: 14:53
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Support\Arr;

class IndexController extends Controller
{
    public function index(AuthService $authService)
    {
        $menus = $authService->getMenus();
        return view('admin.index.index', compact('menus'));
    }

    public function main()
    {
        $envs = [
            ['name' => '当前 IP',           'value' => request()->ip()],
            ['name' => 'PHP 版本',          'value' => 'PHP/'.PHP_VERSION],
            ['name' => 'Laravel 版本',      'value' => app()->version()],
            ['name' => 'CGI',               'value' => php_sapi_name()],
            ['name' => '系统信息',          'value' => php_uname()],
            ['name' => 'Server',            'value' => Arr::get($_SERVER, 'SERVER_SOFTWARE')],
            ['name' => 'Cache driver',      'value' => config('cache.default')],
            ['name' => 'Session driver',    'value' => config('session.driver')],
            ['name' => 'Queue driver',      'value' => config('queue.default')],
            ['name' => 'Timezone',          'value' => config('app.timezone')],
            ['name' => 'Locale',            'value' => config('app.locale')],
            ['name' => 'Env',               'value' => config('app.env')],
            ['name' => 'URL',               'value' => config('app.url')],
        ];
        $data = [
            'envs' => $envs
        ];
        return view('admin.index.main', $data);
    }
}
