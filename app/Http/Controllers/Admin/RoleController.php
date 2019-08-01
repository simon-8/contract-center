<?php
/**
 * Note: 角色控制器
 * User: Liu
 * Date: 2018/11/11
 * Time: 11:47
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\RoleRequest;
use App\Models\RoleAccess;
use App\Models\Role;
use App\Services\ModelService;

class RoleController extends Controller
{
    /**
     * 列表
     * @param Role $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Role $role)
    {
        $lists = $role->paginate();
        return view('admin.role.index' , compact('lists'));
    }

    /**
     * 创建
     * @param RoleAccess $roleAccess
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(RoleAccess $roleAccess)
    {
        $accessLists = $roleAccess->accessLists();
        return view('admin.role.create', compact('accessLists'));
    }

    /**
     * 新增
     * @param RoleRequest $request
     * @param RoleAccess $roleAccess
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(RoleRequest $request, RoleAccess $roleAccess, Role $role)
    {
        $data = $request->all();
        $request->validateCreate($data);
        $data['status'] = $data['status'] ?? 0;

        // 处理无用access
        $data['access'] = $roleAccess->makeAccess($data['access']);

        if (!$role->create($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('admin.role.index')->with('message' , __('web.success'));
    }

    /**
     * 编辑
     * @param Role $role
     * @param RoleAccess $roleAccess
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(RoleAccess $roleAccess, Role $role)
    {
        $accessLists = $roleAccess->accessLists();
        $role['accessLists'] = $accessLists;
        return view('admin.role.create', $role);
    }

    /**
     * 更新
     * @param RoleRequest $request
     * @param RoleAccess $roleAccess
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function update(RoleRequest $request, RoleAccess $roleAccess, Role $role)
    {
        $data = $request->all();
        $request->validateUpdate($data);
        $data['status'] = $data['status'] ?? 0;

        // 处理无用access
        $data['access'] = $roleAccess->makeAccess($data['access']);

        if (!$role->update($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('admin.role.index')->with('message' , __('web.success'));
    }

    /**
     * 删除
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        if (!$role->delete()) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('admin.role.index')->with('message' , __('web.success'));
    }
}