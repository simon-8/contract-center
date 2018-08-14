<?php
/**
 * Note: 管理员管理
 * User: Liu
 * Date: 2018/3/18
 * Time: 11:47
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\ManagerRequest;
use App\Repositories\ManagerRepository;
use App\Repositories\RolesRepository;

class ManagerController extends Controller
{
    /**
     * 列表
     * @param ManagerRepository $repository
     * @return mixed
     */
    public function index(ManagerRepository $repository)
    {
        $lists = $repository->lists();
        $data = [
            'lists' => $lists,
        ];
        return admin_view('manager.index' , $data);
    }

    /**
     * 创建
     * @param RolesRepository $rolesRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(RolesRepository $rolesRepository)
    {
        $data = [
            'roles' => $rolesRepository->lists(['status' => 1], false)
        ];
        return admin_view('manager.create', $data);
    }

    /**
     * 保存
     * @param ManagerRequest $request
     * @param ManagerRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse|mixed
     */
    public function store(ManagerRequest $request, ManagerRepository $repository)
    {
        $data = $request->all();
        $data['avatar'] = upload_base64_thumb($data['avatar']);

        $request->validateCreate($data);

        if (!$repository->create($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('manager.index')->with('message' , __('web.success'));
    }

    /**
     * 编辑
     * @param \Request $request
     * @param ManagerRepository $repository
     * @param RolesRepository $rolesRepository
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(\Request $request, ManagerRepository $repository, RolesRepository $rolesRepository, $id)
    {
        $data = $repository->find($request::input('id'));
        $data['roles'] = $rolesRepository->lists(['status' => 1], false);
        return admin_view('manager.create', $data);
    }

    /**
     * 更新
     * @param ManagerRequest $request
     * @param ManagerRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse|mixed
     */
    public function update(ManagerRequest $request, ManagerRepository $repository)
    {
        $data = $request->all();
        $data['avatar'] = upload_base64_thumb($data['avatar']);
        if (empty($data['password'])) unset($data['password']);

        $request->validateUpdate($data);

        if (!$repository->update($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('manager.index')->with('message' , __('web.success'));
    }

    /**
     * 删除
     * @param ManagerRepository $repository
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function destroy(ManagerRepository $repository, $id)
    {
        if ($repository->delete($id)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('manager.index')->with('message' , __('web.success'));
    }
}