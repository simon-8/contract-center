<?php
/**
 * Note: 活动管理
 * User: Liu
 * Date: 2018/3/17
 * Time: 12:47
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\ActivityStore;
use App\Repositories\ActivityRepository;
use App\Repositories\LotteryRepository;

class ActivityController extends Controller
{
    /**
     * 列表
     * @param ActivityRepository $repository
     * @return mixed
     */
    public function getIndex(ActivityRepository $repository)
    {
        $lists = $repository->lists();
        $data = [
            'lists' => $lists,
        ];
        return admin_view('activity.index' , $data);
    }

    /**
     * 新增
     * @param \Request $request
     * @param ActivityRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse|mixed
     */
    public function doCreate(\Request $request, ActivityRepository $repository)
    {
        if ($request::isMethod('get')) {
            return admin_view('activity.create');
        }
        $data = $request::all();

        $validator = ActivityStore::validateCreate($data);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($repository->create($data)) {
            return redirect()->route('admin.activity.index')->with('Message' , '添加成功');
        } else {
            return back()->withErrors('添加失败')->withInput();
        }
    }

    /**
     * 更新
     * @param \Request $request
     * @param ActivityRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse|mixed
     */
    public function doUpdate(\Request $request, ActivityRepository $repository)
    {
        if ($request::isMethod('get')) {
            $data = $repository->find($request::input('id'));
            return admin_view('activity.create', $data);
        }
        $data = $request::all();

        $validator = ActivityStore::validateUpdate($data);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($repository->update($data)) {
            return redirect()->route('admin.activity.index')->with('Message' , '更新成功');
        } else {
            return back()->withErrors('更新失败')->withInput();
        }
    }

    /**
     * 删除
     * @param \Request $request
     * @param ActivityRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getDelete(\Request $request, ActivityRepository $repository)
    {
        $data = $request::all();
        if ($repository->delete($data['id'])) {
            return redirect()->route('admin.activity.index')->with('Message' , '删除成功');
        } else {
            return back()->withErrors('删除失败')->withInput();
        }
    }

    /**
     * 指定活动已抽奖记录
     * @param LotteryRepository $repository
     * @param $aid
     * @return mixed
     */
    public function getLottery(LotteryRepository $repository, $aid)
    {
        $lists = $repository->lists($aid);
        return admin_view('activity.lottery', [
            'lists' => $lists
        ]);
    }
}