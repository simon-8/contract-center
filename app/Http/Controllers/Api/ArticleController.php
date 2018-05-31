<?php
/**
 * Note: 文章
 * User: Liu
 * Date: 2018/4/10
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\ArticleRepository;
use Chenhua\MarkdownEditor\Facades\MarkdownEditor;

class ArticleController extends Controller
{
    /**
     * 列表
     * @param \Request $request
     * @param ArticleRepository $articleRepository
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(\Request $request, ArticleRepository $articleRepository)
    {
        $where = [];
        if ($request::has('catid') && $request::input('catid')) {
            $where['catid'] = $request::input('catid');
        }
        if ($request::has('pagesize')) {
            $articleRepository::$pageSize = $request::input('pagesize');
        }
        return $articleRepository->listBy($where);
    }

    /**
     * 详情
     * @param ArticleRepository $articleRepository
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public function show(ArticleRepository $articleRepository, $id)
    {
        try {
            $data = $articleRepository->find($id, true);
        } catch (\Exception $exception) {
            return response('', 404);
        }
        $data->increment('hits', 1);

        $data = $data->toArray();
        $data['content'] = $data['content']['content'];
        if ($data['is_md']) {
            $data['content'] = MarkdownEditor::parse($data['content']);
        }
        $data['prev'] = $articleRepository->previous($data['id']);
        $data['next'] = $articleRepository->next($data['id']);
        return $data;
    }

    /**
     * 根据标签获取列表
     * @param ArticleRepository $articleRepository
     * @param int $tagid
     * @return mixed
     */
    public function listByTag(ArticleRepository $articleRepository, $tagid = 0)
    {
        return $articleRepository->getModel()->whereHas('tags', function($query) use ($tagid) {
            $query->where('id', '=', $tagid);
        })->paginate($articleRepository::$pageSize);
    }
}