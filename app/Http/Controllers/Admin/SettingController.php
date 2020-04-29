<?php
/**
 * Note: 设置
 * User: Liu
 * Date: 2018/11/11
 * Time: 11:47
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use App\Services\ModelService;

class SettingController extends Controller
{
    /**
     * 列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $setting = Setting::get()->pluck('value', 'item')->all();
        return view('admin.setting.index', compact('setting'));
    }

    /**
     * 创建
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    //public function create()
    //{
    //    return view('admin.setting.create');
    //}

    /**
     * 新增
     * @param SettingRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    //public function store(SettingRequest $request)
    //{
    //    $data = $request->all();
    //    $request->validateCreate($data);
    //
    //    if (!Setting::create($data)) {
    //        return back()->withErrors(__('web.failed'))->withInput();
    //    }
    //    return redirect()->route('admin.setting.index')->with('message' , __('web.success'));
    //}

    /**
     * 编辑
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    //public function edit()
    //{
    //    return view('admin.setting.create');
    //}

    /**
     * 更新
     * @param SettingRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function update(SettingRequest $request)
    {
        $data = $request->all();
        $request->validateUpdate($data);

        foreach ($request->data as $k => $v) {
            Setting::updateOrCreate([
                'item' => $k,
            ], [
                'value' => $v,
            ]);
        }
        return redirect()->route('admin.setting.index')->with('message' , __('web.success'));
    }

    /**
     * 删除
     * @param Setting $setting
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    //public function destroy(Setting $setting)
    //{
    //    if (!$setting->delete()) {
    //        return back()->withErrors(__('web.failed'))->withInput();
    //    }
    //    return redirect()->route('admin.setting.index')->with('message' , __('web.success'));
    //}
}
