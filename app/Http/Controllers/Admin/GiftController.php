<?php
/**
 * Note: 奖品管理
 * User: Liu
 * Date: 2018/3/17
 * Time: 10:47
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\GiftStore;
use App\Repositories\GiftRepository;

class GiftController extends Controller
{
    /**
     * 列表
     * @param GiftRepository $repository
     * @return mixed
     */
    public function getIndex(GiftRepository $repository)
    {
        $lists = $repository->lists();
        $data = [
            'lists' => $lists,
        ];
        return admin_view('gift.index' , $data);
    }

    /**
     * 新增
     * @param \Request $request
     * @param GiftRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse|mixed
     */
    public function doCreate(\Request $request, GiftRepository $repository)
    {
        if ($request::isMethod('get')) {
            return admin_view('gift.create');
        }
        $data = $request::all();
        $data['thumb'] = upload_base64_thumb($data['thumb']);

        $validator = GiftStore::validateCreate($data);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($repository->create($data)) {
            return redirect()->route('admin.gift.index')->with('Message' , '添加成功');
        } else {
            return back()->withErrors('添加失败')->withInput();
        }
    }

    /**
     * 更新
     * @param \Request $request
     * @param GiftRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse|mixed
     */
    public function doUpdate(\Request $request, GiftRepository $repository)
    {
        if ($request::isMethod('get')) {
            $data = $repository->find($request::input('id'));
            return admin_view('gift.create', $data);
        }
        $data = $request::all();
        $data['thumb'] = upload_base64_thumb($data['thumb']);

        $validator = GiftStore::validateUpdate($data);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($repository->update($data)) {
            return redirect()->route('admin.gift.index')->with('Message' , '更新成功');
        } else {
            return back()->withErrors('更新失败')->withInput();
        }
    }

    /**
     * 删除
     * @param \Request $request
     * @param GiftRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getDelete(\Request $request, GiftRepository $repository)
    {
        $data = $request::all();
        if ($repository->delete($data['id'])) {
            return redirect()->route('admin.gift.index')->with('Message' , '删除成功');
        } else {
            return back()->withErrors('删除失败')->withInput();
        }
    }
}