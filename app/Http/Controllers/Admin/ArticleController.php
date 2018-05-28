<?php
/**
 * Note: 文章管理
 * User: Liu
 * Date: 2018/4/3
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Http\Requests\ArticleStore;

class ArticleController extends BaseController
{
    protected static $PID = 1;

    /**
     * 列表页
     * @param \Request $request
     * @param ArticleRepository $repository
     * @param CategoryRepository $categoryRepository
     * @return mixed
     */
    public function getIndex(\Request $request, ArticleRepository $repository, CategoryRepository $categoryRepository)
    {
        $catid = $request::input('catid', 0);
        $status = $request::input('status', 0);
        $keyword = $request::input('keyword', null);

        $where = [];
        if ($catid) $where['catid'] = $catid;
        if ($status) $where['status'] = $status;
        if ($keyword) $where['keyword'] = $keyword;

        $lists = $repository->listBy($where);

        $categorys = $categoryRepository->listByPID(self::$PID);
        $status_num = $repository->get_status_num();

        $data = [
            'lists' => $lists,
            'status_num' => $status_num,
            'categorys'  => $categorys,
            'catid' => $catid,
            'status' => $status,
            'keyword' => $keyword,
        ];
        return admin_view('article.index', $data);
    }

    /**
     * 新增
     * @param \Request $request
     * @param ArticleRepository $repository
     * @param CategoryRepository $categoryRepository
     * @return $this|\Illuminate\Http\RedirectResponse|mixed
     */
    public function doCreate(\Request $request, ArticleRepository $repository, CategoryRepository $categoryRepository)
    {
        if ($request::isMethod('get')) {
            $categorys = $categoryRepository->listByPID(self::$PID);
            return admin_view('article.create', [
                'categorys' => $categorys
            ]);
        }

        $data = $request::all();
        $data['thumb'] = upload_base64_thumb($data['thumb']);
        $data['is_md'] = is_markdown();

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
     * @param CategoryRepository $categoryRepository
     * @return $this|\Illuminate\Http\RedirectResponse|mixed
     */
    public function doUpdate(\Request $request, ArticleRepository $repository, CategoryRepository $categoryRepository)
    {
        if ($request::isMethod('get')) {
            $data = $repository->find($request::input('id'), true);
            $categorys = $categoryRepository->listByPID(self::$PID);
            $data['categorys'] = $categorys;
            return admin_view('article.create', $data);
        }

        $data = $request::all();
        $data['thumb'] = upload_base64_thumb($data['thumb']);
        $data['is_md'] = is_markdown();

        $validator = ArticleStore::validateUpdate($data);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($repository->update($data)) {
            return redirect()->route('admin.article.index')->with('Message', '更新成功');
        } else {
            return back()->withErrors('更新失败')->withInput();
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