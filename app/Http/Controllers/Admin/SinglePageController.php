<?php
/**
 * Note: 单页管理
 * User: Liu
 * Date: 2018/11/21
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\SinglePage;
use App\Http\Requests\SinglePageRequest;
use App\Services\ModelService;

class SinglePageController extends Controller
{
    protected static $MID = 1;

    /**
     * 列表页
     * @param \Request $request
     * @param SinglePage $singlePage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(\Request $request, SinglePage $singlePage)
    {
        $data = $request::only(['catid', 'status', 'keyword']);

        $lists = $singlePage->ofStatus($data['status'] ?? '')
            ->ofTitle($data['keyword'] ?? '')
            ->ofCatid($data['catid'] ?? '')
            ->orderByDesc('listorder')
            ->paginate();
        $lists->appends($data);

        $categorys = $singlePage->getCats();
        $status_num = $singlePage->get_status_num();
        return view('admin.single_page.index', compact('lists', 'status_num', 'categorys','data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.single_page.create');
    }

    /**
     * 新增
     * @param SinglePageRequest $request
     * @param SinglePage $singlePage
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SinglePageRequest $request, SinglePage $singlePage)
    {
        $data = $request->all();
        $data['thumb'] = upload_base64_thumb($data['thumb']);

        $request->validateCreate($data);
        $data['status'] = $data['status'] ?? 0;
        $data['adminid'] = auth('admin')->user()->id;
        if (!$singlePage->create($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('admin.single-page.index')->with('message' , __('web.success'));
    }

    /**
     * 编辑
     * @param SinglePage $singlePage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(SinglePage $singlePage)
    {
        return view('admin.single_page.create', compact('singlePage'));
    }

    /**
     * 更新
     * @param SinglePageRequest $request
     * @param SinglePage $singlePage
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SinglePageRequest $request, SinglePage $singlePage)
    {
        $data = $request->all();
        $data['thumb'] = upload_base64_thumb($data['thumb']);

        $request->validateUpdate($data);
        $data['status'] = $data['status'] ?? 0;
        $data['adminid'] = auth('admin')->user()->id;
        if (!$singlePage->update($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('admin.single-page.index')->with('message', __('web.success'));
    }

    /**
     * 删除
     * @param SinglePage $singlePage
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(SinglePage $singlePage)
    {
        if ($singlePage->id < 5) return back()->withErrors(__('web.no_allow_delete'));
        if (!$singlePage->delete()) {
            return back()->withErrors(__('web.failed'));
        }
        return redirect()->route('admin.single-page.index')->with('message', __('web.success'));
    }
}
