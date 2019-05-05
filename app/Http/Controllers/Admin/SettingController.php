<?php
/**
 * Note: 设置
 * User: Liu
 * Date: 2018/3/17
 * Time: 12:47
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\SettingRequest;
use App\Repositories\AdminLogsRepository;
use App\Repositories\SettingRepository;

class SettingController extends Controller
{
    /**
     * 列表
     * @param SettingRepository $repository
     * @return mixed
     */
    public function index(SettingRepository $repository)
    {
        $lists = $repository->all()->toArray();

        $data = [
            'lists' => $lists,
        ];
        return admin_view('setting.index' , $data);
    }

    /**
     * @param SettingRequest $request
     * @param SettingRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(SettingRequest $request, SettingRepository $repository)
    {
        $data = $request->all();

        $request->validateCreate($data);

        if (!$repository->updateOrCreate($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('setting.index')->with('message', __('web.success'));
    }

    /**
     * @param SettingRequest $request
     * @param SettingRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(SettingRequest $request, SettingRepository $repository)
    {
        $data = $request->input('data');

        //$request->validateUpdate($data);

        if (!$repository->updateAll($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('setting.index')->with('message', __('web.success'));
    }

    /**
     * 删除
     * @param SettingRepository $repository
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function destroy(SettingRepository $repository, $id)
    {
        if (!$repository->delete($id)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('setting.index')->with('message', __('web.success'));
    }

    /**
     * 管理员操作日志
     * @param \Request $request
     * @param AdminLogsRepository $adminLogsRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminLogs(\Request $request, AdminLogsRepository $adminLogsRepository)
    {
        $lists = $adminLogsRepository->lists();
        //$lists->appends($data);
        return admin_view('setting.adminlogs', compact('lists'));
    }
}