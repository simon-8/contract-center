<?php
/**
 * Note: 文章管理
 * User: Liu
 * Date: 2018/4/3
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Repositories\ArticleRepository;
use App\Http\Requests\ArticleStore;

class ArticleController extends Controller
{
    /**
     * 列表页
     * @param ArticleRepository $repository
     * @return mixed
     */
    public function getIndex(ArticleRepository $repository)
    {
        $lists = $repository->list();
        $status_num = $repository->get_status_num();

        $data = [
            'lists' => $lists,
            'status_num' => $status_num
        ];
        return admin_view('article.index', $data);
    }

    /**
     * 新增
     * @param \Request $request
     * @param ArticleRepository $repository
     * @return mixed
     */
    public function doCreate(\Request $request, ArticleRepository $repository)
    {
        if ($request::isMethod('get')) {
            return admin_view('article.create');
        }

        $data = $request::all();
        $data['thumb'] = upload_base64_thumb($data['thumb']);

        $validator = ArticleStore::validateCreate($data);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($repository->create($data)) {
            return redirect()->route('admin.article.index')->with('Message' , '添加成功');
        } else {
            return back()->withErrors('添加失败')->withInput();
        }
    }

    /**
     * 更新
     * @param \Request $request
     * @param ArticleRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse|mixed
     */
    public function doUpdate(\Request $request, ArticleRepository $repository)
    {
        if ($request::isMethod('get')) {
            $data = $repository->find($request::input('id'), true);
            return admin_view('article.create', $data);
        }

        $data = $request::all();
        $data['thumb'] = upload_base64_thumb($data['thumb']);

        $validator = ArticleStore::validateUpdate($data);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($repository->update($data)) {
            return redirect()->route('admin.article.index')->with('Message', '更新成功');
        } else {
            return back()->withErrors('添加失败')->withInput();
        }
    }

    /**
     * 删除
     * @param \Request $request
     * @param ArticleRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getDelete(\Request $request, ArticleRepository $repository)
    {
        $data = $request::all();
        $item = $repository->find($data['id']);
        if ($item->delete()) {
            return redirect()->route('admin.article.index')->with('Message' , '删除成功');
        } else {
            return back()->withErrors('删除失败')->withInput();
        }
    }
}