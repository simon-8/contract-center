<?php
/**
 * Note: 广告位管理
 * User: Liu
 * Date: 2018/3/12
 * Time: 21:50
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

class AdController extends Controller
{
    public function getIndex()
    {
        $data = [
            'lists' => []
        ];
        return admin_view('ad.index', $data);
    }

    public function getCreate()
    {

    }
}