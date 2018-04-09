<?php
/**
 * Note: 设置
 * User: Liu
 * Date: 2018/3/17
 * Time: 12:47
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\SettingStore;
use App\Repositories\SettingRepository;

class SettingController extends Controller
{
    /**
     * 列表
     * @param SettingRepository $repository
     * @return mixed
     */
    public function getIndex(SettingRepository $repository)
    {
        $lists = $repository->list();

        $data = [
            'lists' => $lists,
        ];
        return admin_view('setting.index' , $data);
    }

    /**
     * @param \Request $request
     * @param SettingRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postCreate(\Request $request, SettingRepository $repository)
    {
        $data = $request::all();
        $validator = SettingStore::validateCreate($data);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($repository->updateOrCreate($data)) {
            return redirect()->route('admin.setting.index')->with('Message' , '操作成功');
        } else {
            return back()->withErrors('操作失败')->withInput();
        }
    }

    /**
     * @param \Request $request
     * @param SettingRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postUpdate(\Request $request, SettingRepository $repository)
    {
        $data = $request::input('data');
        //$validator = SettingStore::validateUpdate($data);
        //if ($validator->fails()) {
        //    return back()->withErrors($validator)->withInput();
        //}

        if ($repository->updateAll($data)) {
            return redirect()->route('admin.setting.index')->with('Message' , '更新成功');
        } else {
            return back()->withErrors('更新失败')->withInput();
        }
    }

    /**
     * 删除
     * @param \Request $request
     * @param SettingRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getDelete(\Request $request, SettingRepository $repository)
    {
        $data = $request::all();
        if ($repository->delete($data['id'])) {
            return redirect()->route('admin.setting.index')->with('Message' , '删除成功');
        } else {
            return back()->withErrors('删除失败')->withInput();
        }
    }
}