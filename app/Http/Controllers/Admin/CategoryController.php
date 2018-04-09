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
    public function getIndex(\Request $request, CategoryRepository $repository)
    {
        $pid = $request::input('pid', 0);
        $parent = $repository->find($pid);

        $lists = $repository->listBy([
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
    public function postCreate(\Request $request, CategoryRepository $repository)
    {
        $data = $request::all();
        if ($repository->create($data)) {
            return redirect()->route('admin.category.index', ['pid' => $data['pid']])->with('Message' , '添加成功');
        } else {
            return back()->withErrors('添加失败')->withInput();
        }
    }

    /**
     * 更新
     * @param \Request $request
     * @param CategoryRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postUpdate(\Request $request, CategoryRepository $repository)
    {
        $data = $request::all();
        if ($repository->update($data)) {
            return redirect()->route('admin.category.index', ['pid' => $data['pid']])->with('Message' , '更新成功');
        } else {
            return back()->withErrors('更新失败')->withInput();
        }
    }

    /**
     * 删除
     * @param \Request $request
     * @param CategoryRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getDelete(\Request $request, CategoryRepository $repository)
    {
        $data = $request::all();
        $item = $repository->find($data['id']);
        if ($item->delete()) {
            return redirect()->route('admin.category.index', ['pid' => $item['pid']])->with('Message' , '删除成功');
        } else {
            return back()->withErrors('删除失败')->withInput();
        }
    }
}