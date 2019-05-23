<?php
/**
 * Note: 管理员管理
 * User: Liu
 * Date: 2018/11/01
 */
namespace App\Http\Controllers\Admin;

use App\Models\Manager;
use App\Repositories\ManagerRepository;
use App\Http\Requests\ManagerRequest;
use App\Services\ModelService;

class ManagerController extends BaseController
{
    /**
     * 列表
     * @param Manager $manager
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Manager $manager)
    {
        $lists = $manager->paginate(ModelService::$pagesize);
        return view('admin.manager.index', compact('lists'));
    }

    /**
     * 创建
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.manager.create');
    }

    /**
     * 保存
     * @param ManagerRequest $request
     * @param Manager $manager
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ManagerRequest $request, Manager $manager)
    {
        $data = $request->all();
        $data['avatar'] = upload_base64_thumb($data['avatar']);
        $request->validateCreate($data);

        if (!$manager->create($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }

        return redirect()->route('admin.manager.index')->with('message', __('web.success'));
    }

    /**
     * 编辑
     * @param Manager $manager
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Manager $manager)
    {
        return view('admin.manager.create', $manager);
    }

    /**
     * 更新
     * @param ManagerRequest $request
     * @param Manager $manager
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ManagerRequest $request, Manager $manager)
    {
        $data = $request->all();
        $data['avatar'] = upload_base64_thumb($data['avatar']);
        $request->validateUpdate($data);

        if (empty($data['password'])) unset($data['password']);

        if (!$manager->update($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }

        return redirect()->route('admin.manager.index')->with('message', __('web.success'));
    }

    /**
     * 删除
     * @param Manager $manager
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Manager $manager)
    {
        if ($manager->id == 1) return back()->withErrors(__('web.no_allow_delete'));

        if (!$manager->delete()) {
            return back()->withErrors(__('web.failed'));
        }
        return redirect()->route('admin.manager.index')->with('message', __('web.success'));
    }

}