<?php
/**
 * Note: 分类
 * User: Liu
 * Date: 2018/4/4
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    /**
     * 列表页
     * @param \Request $request
     * @param CategoryRepository $repository
     * @return mixed
     */
    public function index(\Request $request, CategoryRepository $repository)
    {
        $pid = $request::input('pid', 0);
        $parent = $repository->find($pid);

        $lists = $repository->lists([
            'pid' => $pid
        ]);

        $data = [
            'lists' => $lists,
            'pid' => $pid,
            'parent' => $parent
        ];
        return admin_view('category.index', $data);
    }

    /**
     * 添加
     * @param \Request $request
     * @param CategoryRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(\Request $request, CategoryRepository $repository)
    {
        $data = $request::all();
        if (!$repository->create($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('category.index', ['pid' => $data['pid']])->with('message', __('web.success'));
    }

    /**
     * 更新
     * @param \Request $request
     * @param CategoryRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(\Request $request, CategoryRepository $repository)
    {
        $data = $request::all();
        if (!$repository->update($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('category.index', ['pid' => $data['pid']])->with('message', __('web.success'));
    }

    /**
     * 删除
     * @param CategoryRepository $repository
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function destroy(CategoryRepository $repository, $id)
    {
        $item = $repository->find($id);
        if (!$item->delete()) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('category.index', ['pid' => $item['pid']])->with('message', __('web.success'));
    }
}