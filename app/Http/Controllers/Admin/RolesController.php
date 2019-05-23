<?php
/**
 * Note: 角色控制器
 * User: Liu
 * Date: 2018/11/11
 * Time: 11:47
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\RolesRequest;
use App\Models\RoleAccess;
use App\Models\Roles;
use App\Repositories\RolesRepository;
use App\Repositories\RoleAccessRepository;
use App\Services\ModelService;

class RolesController extends Controller
{
    /**
     * 列表
     * @param Roles $roles
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Roles $roles)
    {
        $lists = $roles->paginate(ModelService::$pagesize);
        return view('admin.roles.index' , compact('lists'));
    }

    /**
     * 创建
     * @param RoleAccess $roleAccess
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(RoleAccess $roleAccess)
    {
        $accessLists = $roleAccess->accessLists();
        return view('admin.roles.create', compact('accessLists'));
    }

    /**
     * 新增
     * @param RolesRequest $request
     * @param Roles $roles
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(RolesRequest $request, Roles $roles)
    {
        $data = $request->all();
        $request->validateCreate($data);

        if (!$roles->create($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('admin.roles.index')->with('message' , __('web.success'));
    }

    /**
     * 编辑
     * @param Roles $roles
     * @param RoleAccess $roleAccess
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(RoleAccess $roleAccess, Roles $roles)
    {
        $accessLists = $roleAccess->accessLists();
        $roles['accessLists'] = $accessLists;
        return view('admin.roles.create', $roles);
    }

    /**
     * 更新
     * @param RolesRequest $request
     * @param Roles $roles
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function update(RolesRequest $request, Roles $roles)
    {
        $data = $request->all();
        $request->validateUpdate($data);

        if (!$roles->update($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('admin.roles.index')->with('message' , __('web.success'));
    }

    /**
     * 删除
     * @param Roles $roles
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Roles $roles)
    {
        if (!$roles->delete()) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('admin.roles.index')->with('message' , __('web.success'));
    }
}