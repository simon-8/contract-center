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
use App\Repositories\ArticleRepository;
use App\Repositories\SinglePageRepository;
use App\Repositories\HitRecordRepository;

class IndexController extends Controller
{
    public function getMain(MenuRepository $menuRepository)
    {
        $userAccessKey = 'userAccess'.auth()->guard('admin')->getUser()->id;
        $routes = \Cache::get($userAccessKey);

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

        $data = [
            'menus' => $myMenus
        ];
        return admin_view('index.main', $data);
    }

    public function getIndex(ArticleRepository $articleRepository, SinglePageRepository $singlePageRepository, HitRecordRepository $hitRecordRepository)
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
        $counts = [
            'articleTotal' => $articleRepository->count(),
            'articleDaily' => $articleRepository->dailyInsertCount(),
            'singleTotal'  => $singlePageRepository->count(),
            'singleDaily'  => $singlePageRepository->dailyInsertCount(),
            'hitsDaily'    => $hitRecordRepository->sum(date('Y-m-d'))
        ];
        $counts['articleInsertPrecent'] = $counts['articleDaily'] ? sprintf('%.2f', ($counts['articleDaily'] / $counts['articleTotal'])*100) : 0;
        $counts['singleInsertPrecent'] = $counts['singleDaily'] ? sprintf('%.2f', ($counts['singleDaily'] / $counts['singleTotal'])*100) : 0;
        $data = [
            'envs'  => $envs,
            'counts'=> $counts
        ];
        return admin_view('index.index', $data);
    }
}