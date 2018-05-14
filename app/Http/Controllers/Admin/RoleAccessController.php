<?php
/**
 * Note: 权限管理
 * User: Liu
 * Date: 2018/5/12
 * Time: 11:47
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\RoleAccessStore;
use App\Repositories\RoleAccessRepository;

class RoleAccessController extends Controller
{
    protected static $allowMethods = ['GET', 'POST', 'PUT', 'DELETE'];

    /**
     * 列表
     * @param RoleAccessRepository $repository
     * @return mixed
     */
    public function getIndex(RoleAccessRepository $repository)
    {
        $lists = $repository->list();
        $routeNames = \Route::getRoutes()->getRoutesByName();
        $data = [
            'lists' => $lists,
            'routeNames' => $routeNames
        ];
        return admin_view('roleaccess.index' , $data);
    }

    /**
     * 新增
     * @param \Request $request
     * @param RoleAccessRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse|mixed
     */
    public function doCreate(\Request $request, RoleAccessRepository $repository)
    {
        if ($request::isMethod('get')) {
            $data = [
                'allowMethods' => self::$allowMethods
            ];
            return admin_view('roleaccess.create', $data);
        }
        $data = $request::all();

        $validator = RoleAccessStore::validateCreate($data);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($repository->create($data)) {
            return redirect()->route('admin.roleaccess.index')->with('Message' , '添加成功');
        } else {
            return back()->withErrors('添加失败')->withInput();
        }
    }

    /**
     * 更新
     * @param \Request $request
     * @param RoleAccessRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse|mixed
     */
    public function doUpdate(\Request $request, RoleAccessRepository $repository)
    {
        if ($request::isMethod('get')) {
            $data = $repository->find($request::input('id'));
            $data['allowMethods'] = self::$allowMethods;
            return admin_view('roleaccess.create', $data);
        }
        $data = $request::all();

        $validator = RoleAccessStore::validateUpdate($data);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($repository->update($data)) {
            return redirect()->route('admin.roleaccess.index')->with('Message' , '更新成功');
        } else {
            return back()->withErrors('更新失败')->withInput();
        }
    }

    /**
     * 删除
     * @param \Request $request
     * @param RoleAccessRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getDelete(\Request $request, RoleAccessRepository $repository)
    {
        $data = $request::all();
        if ($repository->delete($data['id'])) {
            return redirect()->route('admin.roleaccess.index')->with('Message' , '删除成功');
        } else {
            return back()->withErrors('删除失败')->withInput();
        }
    }
}