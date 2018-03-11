<?php
/**
 * Note: 后台管理菜单
 * User: Liu
 * Date: 2018/3/11
 * Time: 16:43
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Repositories\MenuRepository;

class MenuController extends Controller
{
    /**
     * 列表
     * @param MenuRepository $menuRepository
     * @return mixed
     */
    public function getIndex(MenuRepository $menuRepository)
    {
        $lists = $menuRepository->lists();
        $data = [
            'lists' => $lists
        ];
        return admin_view('menu.index', $data);
    }

    /**
     * 添加
     * @param \Request $request
     * @param MenuRepository $menuRepository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postCreate(\Request $request, MenuRepository $menuRepository)
    {
        $data = $request::all();
        if ($menuRepository->create($data)) {
            return redirect()->route('admin.menu.index')->with('Message' , '添加成功');
        } else {
            return back()->withErrors('添加失败')->withInput();
        }
    }

    /**
     * 更新
     * @param \Request $request
     * @param MenuRepository $menuRepository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postUpdate(\Request $request, MenuRepository $menuRepository)
    {
        $data = $request::all();
        if ($menuRepository->update($data)) {
            return redirect()->route('admin.menu.index')->with('Message' , '更新成功');
        } else {
            return back()->withErrors('更新失败')->withInput();
        }
    }

    /**
     * 删除
     * @param \Request $request
     * @param MenuRepository $menuRepository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getDelete(\Request $request, MenuRepository $menuRepository)
    {
        $data = $request::all();
        if ($menuRepository->delete($data['id'])) {
            return redirect()->route('admin.menu.index')->with('Message' , '删除成功');
        } else {
            return back()->withErrors('删除失败, 请检查是否有子菜单')->withInput();
        }
    }
}