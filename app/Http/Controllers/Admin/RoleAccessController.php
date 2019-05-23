<?php
/**
 * Note: 权限管理
 * User: Liu
 * Date: 2018/11/14
 * Time: 11:47
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\RoleAccessRequest;
use App\Models\RoleAccess;
use App\Services\ModelService;

class RoleAccessController extends Controller
{
    /**
     * 列表
     * @param RoleAccess $roleAccess
     * @return mixed
     */
    public function index(RoleAccess $roleAccess)
    {
        $lists = $roleAccess->paginate(ModelService::$pagesize);
        return view('admin.role_access.index' , compact('lists'));
    }

    /**
     * 创建
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.role_access.create');
    }

    /**
     * 新增
     * @param RoleAccessRequest $request
     * @param RoleAccess $roleAccess
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(RoleAccessRequest $request, RoleAccess $roleAccess)
    {
        $data = $request->all();
        $request->validateCreate($data);

        if (!$roleAccess->create($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('admin.role-access.index')->with('message' , __('web.success'));
    }

    /**
     * 编辑
     * @param RoleAccess $roleAccess
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(RoleAccess $roleAccess)
    {
        return view('admin.role_access.create', $roleAccess);
    }

    /**
     *  更新
     * @param RoleAccessRequest $request
     * @param RoleAccess $roleAccess
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function update(RoleAccessRequest $request, RoleAccess $roleAccess)
    {
        $data = $request->all();
        $request->validateUpdate($data);

        if (!$roleAccess->update($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('admin.role-access.index')->with('message' , __('web.success'));
    }

    /**
     * 删除
     * @param RoleAccess $roleAccess
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(RoleAccess $roleAccess)
    {
        if (!$roleAccess->delete()) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('admin.role-access.index')->with('message' , __('web.success'));
    }
}