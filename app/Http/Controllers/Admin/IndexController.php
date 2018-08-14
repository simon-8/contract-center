<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/3/11
 * Time: 14:53
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Repositories\ArticleRepository;
use App\Repositories\SinglePageRepository;
use App\Repositories\HitRecordRepository;

use App\Services\AuthService;

class IndexController extends Controller
{
    public function getMain(\Request $request, AuthService $authService)
    {
        return admin_view('index.main');
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