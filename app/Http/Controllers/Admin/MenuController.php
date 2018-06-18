<?php
/**
 * Note: 后台管理菜单
 * User: Liu
 * Date: 2018/3/11
 * Time: 19:43
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\MenuRequest;
use App\Repositories\MenuRepository;

class MenuController extends Controller
{
    /**
     * 列表
     * @param MenuRepository $repository
     * @return mixed
     */
    public function index(MenuRepository $repository)
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
     * @param MenuRequest $request
     * @param MenuRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(MenuRequest $request, MenuRepository $repository)
    {
        $data = $request->all();
        $request->validateCreate($data);

        if (!$repository->create($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('menu.index')->with('Message' , __('web.success'));
    }

    /**
     * 更新
     * @param MenuRequest $request
     * @param MenuRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(MenuRequest $request, MenuRepository $repository)
    {
        $data = $request->all();
        $request->validateUpdate($data);

        if (!$repository->update($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('menu.index')->with('Message' , __('web.success'));
    }

    /**
     * 删除
     * @param MenuRepository $repository
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function destroy(MenuRepository $repository, $id)
    {
        if (!$repository->delete($id)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('menu.index')->with('Message' , __('web.success'));
    }
}