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
use App\Http\Requests\ArticleRequest;

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
    public function index(\Request $request, ArticleRepository $repository, CategoryRepository $categoryRepository)
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
     * @param CategoryRepository $categoryRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(CategoryRepository $categoryRepository)
    {
        $categorys = $categoryRepository->listByPID(self::$PID);
        return admin_view('article.create', [
            'categorys' => $categorys
        ]);
    }

    /**
     * 新增
     * @param ArticleRequest $request
     * @param ArticleRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse|mixed
     */
    public function store(ArticleRequest $request, ArticleRepository $repository)
    {
        $data = $request->all();
        $data['thumb'] = upload_base64_thumb($data['thumb']);
        $data['is_md'] = is_markdown();

        $request->validateCreate($data);

        if (!$repository->create($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('article.index')->with('Message' , __('web.success'));
    }

    /**
     * @param ArticleRepository $repository
     * @param CategoryRepository $categoryRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(ArticleRepository $repository, CategoryRepository $categoryRepository, $id)
    {
        $data = $repository->find($id, true);
        $categorys = $categoryRepository->listByPID(self::$PID);
        $data['categorys'] = $categorys;
        return admin_view('article.create', $data);
    }

    /**
     * 更新
     * @param ArticleRequest $request
     * @param ArticleRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse|mixed
     */
    public function update(ArticleRequest $request, ArticleRepository $repository)
    {
        $data = $request->all();
        $data['thumb'] = upload_base64_thumb($data['thumb']);
        $data['is_md'] = is_markdown();

        $request->validateUpdate($data);

        if (!$repository->update($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('article.index')->with('Message', __('web.success'));
    }

    /**
     * 删除
     * @param ArticleRepository $repository
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function destroy(ArticleRepository $repository, $id)
    {
        if (!$repository->delete($id)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('article.index')->with('Message' , __('web.success'));
    }
}