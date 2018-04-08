<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/3/11
 * Time: 14:53
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Repositories\MenuRepository;
class IndexController extends Controller
{
    public function getMain(MenuRepository $menuRepository)
    {
        $menus = $menuRepository->lists();
        $data = [
            'menus' => $menus
        ];
        return admin_view('index.main', $data);
    }

    public function getIndex()
    {
        $envs = [
            ['name' => 'PHP version',       'value' => 'PHP/'.PHP_VERSION],
            ['name' => 'Laravel version',   'value' => app()->version()],
            ['name' => 'CGI',               'value' => php_sapi_name()],
            ['name' => 'Uname',             'value' => php_uname()],
            ['name' => 'Server',            'value' => array_get($_SERVER, 'SERVER_SOFTWARE')],
            ['name' => 'Cache driver',      'value' => config('cache.default')],
            ['name' => 'Session driver',    'value' => config('session.driver')],
            ['name' => 'Queue driver',      'value' => config('queue.default')],
            ['name' => 'Timezone',          'value' => config('app.timezone')],
            ['name' => 'Locale',            'value' => config('app.locale')],
            ['name' => 'Env',               'value' => config('app.env')],
            ['name' => 'URL',               'value' => config('app.url')],
        ];
        $data = [
            'envs'  => $envs
        ];
        return admin_view('index.index', $data);
    }
}