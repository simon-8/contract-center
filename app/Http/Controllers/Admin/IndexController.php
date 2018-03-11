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
        return admin_view('index.index');
    }
}