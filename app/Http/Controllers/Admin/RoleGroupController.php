<?php
/**
 * Note: 会员组管理
 * User: Liu
 * Date: 2018/5/12
 * Time: 11:47
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\RoleGroupStore;
use App\Repositories\RoleGroupRepository;


class RoleGroupController extends Controller
{
    /**
     * 列表
     * @param RoleGroupRepository $repository
     * @return mixed
     */
    public function getIndex(RoleGroupRepository $repository)
    {
        $lists = $repository->list();
        $data = [
            'lists' => $lists,
        ];

        return admin_view('rolegroup.index' , $data);
    }

    /**
     * 新增
     * @param \Request $request
     * @param RoleGroupRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse|mixed
     */
    public function doCreate(\Request $request, RoleGroupRepository $repository)
    {
        if ($request::isMethod('get')) {
            return admin_view('rolegroup.create');
        }
        $data = $request::all();
        $data['avatar'] = upload_base64_thumb($data['avatar']);

        $validator = RoleGroupStore::validateCreate($data);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($repository->create($data)) {
            return redirect()->route('admin.rolegroup.index')->with('Message' , '添加成功');
        } else {
            return back()->withErrors('添加失败')->withInput();
        }
    }

    /**
     * 更新
     * @param \Request $request
     * @param RoleGroupRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse|mixed
     */
    public function doUpdate(\Request $request, RoleGroupRepository $repository)
    {
        if ($request::isMethod('get')) {
            $data = $repository->find($request::input('id'));
            return admin_view('rolegroup.create', $data);
        }
        $data = $request::all();
        $data['avatar'] = upload_base64_thumb($data['avatar']);
        if (empty($data['password'])) unset($data['password']);

        $validator = RoleGroupStore::validateUpdate($data);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($repository->update($data)) {
            return redirect()->route('admin.rolegroup.index')->with('Message' , '更新成功');
        } else {
            return back()->withErrors('更新失败')->withInput();
        }
    }

    /**
     * 删除
     * @param \Request $request
     * @param RoleGroupRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getDelete(\Request $request, RoleGroupRepository $repository)
    {
        $data = $request::all();
        if ($repository->delete($data['id'])) {
            return redirect()->route('admin.rolegroup.index')->with('Message' , '删除成功');
        } else {
            return back()->withErrors('删除失败')->withInput();
        }
    }
}