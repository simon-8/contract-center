<?php
/**
 * Note: 角色控制器
 * User: Liu
 * Date: 2018/5/12
 * Time: 11:47
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\RolesStore;
use App\Repositories\RolesRepository;
use App\Repositories\RoleAccessRepository;

class RolesController extends Controller
{
    /**
     * 列表
     * @param RolesRepository $repository
     * @return mixed
     */
    public function getIndex(RolesRepository $repository)
    {
        $lists = $repository->list();
        $data = [
            'lists' => $lists,
        ];

        return admin_view('roles.index' , $data);
    }

    /**
     * 新增
     * @param \Request $request
     * @param RolesRepository $repository
     * @param RoleAccessRepository $roleAccessRepository
     * @return $this|\Illuminate\Http\RedirectResponse|mixed
     */
    public function doCreate(\Request $request, RolesRepository $repository, RoleAccessRepository $roleAccessRepository)
    {
        if ($request::isMethod('get')) {
            $accessLists = $roleAccessRepository->getAll();
            $data = [
                'accessLists' => $accessLists
            ];
            return admin_view('roles.create', $data);
        }

        $data = $request::all();

        $validator = RolesStore::validateCreate($data);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($repository->create($data)) {
            return redirect()->route('admin.roles.index')->with('Message' , '添加成功');
        } else {
            return back()->withErrors('添加失败')->withInput();
        }
    }

    /**
     * 更新
     * @param \Request $request
     * @param RolesRepository $repository
     * @param RoleAccessRepository $roleAccessRepository
     * @return $this|\Illuminate\Http\RedirectResponse|mixed
     */
    public function doUpdate(\Request $request, RolesRepository $repository, RoleAccessRepository $roleAccessRepository)
    {
        if ($request::isMethod('get')) {
            $data = $repository->find($request::input('id'));
            $accessLists = $roleAccessRepository->getAll();
            $data['accessLists'] = $accessLists;
            return admin_view('roles.create', $data);
        }
        $data = $request::all();

        $validator = RolesStore::validateUpdate($data);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($repository->update($data)) {
            return redirect()->route('admin.roles.index')->with('Message' , '更新成功');
        } else {
            return back()->withErrors('更新失败')->withInput();
        }
    }

    /**
     * 删除
     * @param \Request $request
     * @param RolesRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getDelete(\Request $request, RolesRepository $repository)
    {
        $data = $request::all();
        if ($repository->delete($data['id'])) {
            return redirect()->route('admin.roles.index')->with('Message' , '删除成功');
        } else {
            return back()->withErrors('删除失败')->withInput();
        }
    }
}