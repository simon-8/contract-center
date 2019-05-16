<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MenuRequest;
use App\Models\Menu;

class MenuController extends BaseController
{
    /**
     * 列表
     * @param Menu $menu
     * @return mixed
     */
    public function index(Menu $menu)
    {
        $lists = $menu->getMenus();
        return view('admin.menu.index', compact('lists'));
    }

    /**
     * 添加
     * @param MenuRequest $request
     * @param Menu $menu
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(MenuRequest $request, Menu $menu)
    {
        $data = $request->all();
        if (!$menu->create($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('admin.menu.index')->with('message' , __('web.success'));
    }

    /**
     * 更新
     * @param MenuRequest $request
     * @param Menu $menu
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(MenuRequest $request, Menu $menu)
    {
        $data = $request->all();
        if (!$menu->update($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('admin.menu.index')->with('message' , __('web.success'));
    }

    /**
     * 删除
     * @param Menu $menu
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Menu $menu)
    {
        if ($menu->children()->count()) {
            return back()->withErrors('删除失败, 请检查是否有子菜单')->withInput();
        }
        if (!$menu->delete()) {
            return back()->withErrors('删除失败')->withInput();
        }
        return redirect()->route('admin.menu.index')->with('message' , __('web.success'));
    }
}
