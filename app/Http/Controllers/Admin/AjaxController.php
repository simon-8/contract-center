<?php
/**
 * Note: Ajax集中处理
 * User: Liu
 * Date: 2018/3/16
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

class AjaxController extends Controller
{
    /**
     * @param \Request $request
     * @return mixed
     */
    public function getIndex(\Request $request)
    {
        $ac = $request::input('ac');
        switch ($ac){
            case 'thumb':
                return admin_view('ajax.'.$ac , $request::all());
                break;
            case 'tags':
                return (new \App\Models\Tag())->all(['id', 'name'])->toArray();
        }
        abort(404);
    }
}