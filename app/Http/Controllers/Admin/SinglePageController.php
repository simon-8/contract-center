<?php
/**
 * Note: 单页管理
 * User: Liu
 * Date: 2018/4/11
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Repositories\SinglePageRepository;
use App\Http\Requests\SinglePageStore;

class SinglePageController extends Controller
{
    protected static $MID = 1;

    /**
     * 列表页
     * @param \Request $request
     * @param SinglePageRepository $repository
     * @return mixed
     */
    public function getIndex(\Request $request, SinglePageRepository $repository)
    {
        $status = $request::input('status', 0);
        $keyword = $request::input('keyword', null);

        $where = [];
        if ($status) $where['status'] = $status;
        if ($keyword) $where['keyword'] = $keyword;

        $lists = $repository->listBy($where);

        $status_num = $repository->get_status_num();

        $data = [
            'lists' => $lists,
            'status_num' => $status_num,
            'status' => $status,
            'keyword' => $keyword,
        ];
        return admin_view('single.index', $data);
    }

    /**
     * 新增
     * @param \Request $request
     * @param SinglePageRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse|mixed
     */
    public function doCreate(\Request $request, SinglePageRepository $repository)
    {
        if ($request::isMethod('get')) {
            return admin_view('single.create');
        }

        $data = $request::all();
        $data['thumb'] = upload_base64_thumb($data['thumb']);

        $validator = SinglePageStore::validateCreate($data);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($repository->create($data)) {
            return redirect()->route('admin.single.index')->with('Message' , '添加成功');
        } else {
            return back()->withErrors('添加失败')->withInput();
        }
    }

    /**
     * 更新
     * @param \Request $request
     * @param SinglePageRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse|mixed
     */
    public function doUpdate(\Request $request, SinglePageRepository $repository)
    {
        if ($request::isMethod('get')) {
            $data = $repository->find($request::input('id'), true);
            return admin_view('single.create', $data);
        }

        $data = $request::all();
        $data['thumb'] = upload_base64_thumb($data['thumb']);

        $validator = SinglePageStore::validateUpdate($data);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($repository->update($data)) {
            return redirect()->route('admin.single.index')->with('Message', '更新成功');
        } else {
            return back()->withErrors('添加失败')->withInput();
        }
    }

    /**
     * 删除
     * @param \Request $request
     * @param SinglePageRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getDelete(\Request $request, SinglePageRepository $repository)
    {
        $data = $request::all();
        $item = $repository->find($data['id']);
        if ($item->delete()) {
            return redirect()->route('admin.single.index')->with('Message' , '删除成功');
        } else {
            return back()->withErrors('删除失败')->withInput();
        }
    }
}