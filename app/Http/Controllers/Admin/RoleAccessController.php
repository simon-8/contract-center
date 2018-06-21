<?php
/**
 * Note: 权限管理
 * User: Liu
 * Date: 2018/5/12
 * Time: 11:47
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\RoleAccessRequest;
use App\Repositories\RoleAccessRepository;

class RoleAccessController extends Controller
{
    protected static $allowMethods = ['GET', 'POST', 'PUT', 'DELETE'];

    /**
     * 列表
     * @param RoleAccessRepository $repository
     * @return mixed
     */
    public function index(RoleAccessRepository $repository)
    {
        $lists = $repository->lists();
        $routeNames = \Route::getRoutes()->getRoutesByName();
        $data = [
            'lists' => $lists,
            'routeNames' => $routeNames
        ];
        return admin_view('role_access.index' , $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $routeNames = \Route::getRoutes()->getRoutesByName();
        $data = [
            'allowMethods' => self::$allowMethods,
            'routeNames'   => $routeNames
        ];
        return admin_view('role_access.create', $data);
    }

    /**
     * 新增
     * @param RoleAccessRequest $request
     * @param RoleAccessRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse|mixed
     */
    public function store(RoleAccessRequest $request, RoleAccessRepository $repository)
    {
        $data = $request->all();

        $request->validateCreate($data);

        if (!$repository->create($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('role-access.index')->with('Message', __('web.success'));
    }

    /**
     * @param RoleAccessRepository $repository
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(RoleAccessRepository $repository, $id)
    {
        $data = $repository->find($id);
        $data['allowMethods'] = self::$allowMethods;
        $data['routeNames'] = \Route::getRoutes()->getRoutesByName();
        return admin_view('role_access.create', $data);
    }

    /**
     * 更新
     * @param RoleAccessRequest $request
     * @param RoleAccessRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse|mixed
     */
    public function update(RoleAccessRequest $request, RoleAccessRepository $repository)
    {
        $data = $request->all();

        $request->validateUpdate($data);

        if (!$repository->update($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('role-access.index')->with('Message', __('web.success'));
    }


    /**
     * 删除
     * @param RoleAccessRepository $repository
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function destroy(RoleAccessRepository $repository, $id)
    {
        if (!$repository->delete($id)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('role-access.index')->with('Message', __('web.success'));
    }
}