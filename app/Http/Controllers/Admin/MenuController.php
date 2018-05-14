<?php
/**
 * Note: 后台管理菜单
 * User: Liu
 * Date: 2018/3/11
 * Time: 19:43
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\MenuStore;

use App\Repositories\MenuRepository;

class MenuController extends Controller
{
    /**
     * 列表
     * @param MenuRepository $repository
     * @return mixed
     */
    public function getIndex(MenuRepository $repository)
    {
        $lists = $repository->lists();
        $routeNames = \Route::getRoutes()->getRoutesByName();
        $data = [
            'lists' => $lists,
            'routeNames' => $routeNames
        ];
        return admin_view('menu.index', $data);
    }

    /**
     * 添加
     * @param \Request $request
     * @param MenuRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postCreate(MenuStore $menuStore, \Request $request, MenuRepository $repository)
    {
        $data = $request::all();
        if ($repository->create($data)) {
            return redirect()->route('admin.menu.index')->with('Message' , '添加成功');
        } else {
            return back()->withErrors('添加失败')->withInput();
        }
    }

    /**
     * 更新
     * @param \Request $request
     * @param MenuRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postUpdate(MenuStore $menuStore, \Request $request, MenuRepository $repository)
    {
        $data = $request::all();
        if ($repository->update($data)) {
            return redirect()->route('admin.menu.index')->with('Message' , '更新成功');
        } else {
            return back()->withErrors('更新失败')->withInput();
        }
    }

    /**
     * 删除
     * @param \Request $request
     * @param MenuRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getDelete(\Request $request, MenuRepository $repository)
    {
        $data = $request::all();
        if ($repository->delete($data['id'])) {
            return redirect()->route('admin.menu.index')->with('Message' , '删除成功');
        } else {
            return back()->withErrors('删除失败, 请检查是否有子菜单')->withInput();
        }
    }
}