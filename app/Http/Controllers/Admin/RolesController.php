<?php
/**
 * Note: 角色控制器
 * User: Liu
 * Date: 2018/5/12
 * Time: 11:47
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\RolesRequest;
use App\Repositories\RolesRepository;
use App\Repositories\RoleAccessRepository;

class RolesController extends Controller
{
    /**
     * 列表
     * @param RolesRepository $repository
     * @return mixed
     */
    public function index(RolesRepository $repository)
    {
        $lists = $repository->lists();
        $data = [
            'lists' => $lists,
        ];

        return admin_view('roles.index' , $data);
    }

    /**
     * @param RoleAccessRepository $roleAccessRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(RoleAccessRepository $roleAccessRepository)
    {
        $accessLists = $roleAccessRepository->all();
        $data = [
            'accessLists' => $accessLists
        ];
        return admin_view('roles.create', $data);
    }

    /**
     * 新增
     * @param RolesRequest $request
     * @param RolesRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse|mixed
     */
    public function store(RolesRequest $request, RolesRepository $repository)
    {
        $data = $request->all();

        $request->validateCreate($data);

        if (!$repository->create($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('roles.index')->with('message', __('web.success'));
    }

    /**
     * @param RolesRepository $repository
     * @param RoleAccessRepository $roleAccessRepository
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(RolesRepository $repository, RoleAccessRepository $roleAccessRepository, $id)
    {
        $data = $repository->find($id);
        $accessLists = $roleAccessRepository->all();
        $data['accessLists'] = $accessLists;
        return admin_view('roles.create', $data);
    }

    /**
     * 更新
     * @param RolesRequest $request
     * @param RolesRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse|mixed
     */
    public function update(RolesRequest $request, RolesRepository $repository)
    {
        $data = $request->all();

        $request->validateUpdate($data);

        if (!$repository->update($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('roles.index')->with('message', __('web.success'));
    }

    /**
     * 删除
     * @param RolesRepository $repository
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function destroy(RolesRepository $repository, $id)
    {
        if (!$repository->delete($id)) {
            return back()->withErrors('web.failed')->withInput();
        }
        return redirect()->route('roles.index')->with('message', __('web.success'));
    }
}