<?php
/**
 * Note: 单页管理
 * User: Liu
 * Date: 2018/4/11
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Repositories\SinglePageRepository;
use App\Http\Requests\SinglePageRequest;

class SinglePageController extends Controller
{
    protected static $MID = 1;

    /**
     * 列表页
     * @param \Request $request
     * @param SinglePageRepository $repository
     * @return mixed
     */
    public function index(\Request $request, SinglePageRepository $repository)
    {
        $status = $request::input('status', 0);
        $keyword = $request::input('keyword', null);

        $where = [];
        if ($status) $where['status'] = $status;
        if ($keyword) $where['keyword'] = $keyword;

        $lists = $repository->lists($where);

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return admin_view('single.create');
    }

    /**
     * 新增
     * @param SinglePageRequest $request
     * @param SinglePageRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse|mixed
     */
    public function store(SinglePageRequest $request, SinglePageRepository $repository)
    {
        $data = $request->all();
        $data['thumb'] = upload_base64_thumb($data['thumb']);

        $request->validateCreate($data);

        if (!$repository->create($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('single.index')->with('message' , __('web.success'));
    }

    /**
     * @param \Request $request
     * @param SinglePageRepository $repository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(\Request $request, SinglePageRepository $repository)
    {
        $data = $repository->find($request::input('id'), true);
        return admin_view('single.create', $data);
    }

    /**
     * 更新
     * @param SinglePageRequest $request
     * @param SinglePageRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse|mixed
     */
    public function update(SinglePageRequest $request, SinglePageRepository $repository)
    {
        $data = $request->all();
        $data['thumb'] = upload_base64_thumb($data['thumb']);

        $request->validateUpdate($data);

        if (!$repository->update($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('single.index')->with('message', __('web.success'));
    }

    /**
     * 删除
     * @param SinglePageRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function destroy(SinglePageRepository $repository, $id)
    {
        if (!$repository->delete($id)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('single.index')->with('message' , __('web.success'));
    }
}