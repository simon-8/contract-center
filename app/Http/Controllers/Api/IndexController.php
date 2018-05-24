<?php
/**
 * Note: 首页所需接口
 * User: Liu
 * Date: 2018/4/10
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\ArticleRepository;
use App\Repositories\AdRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\SinglePageRepository;
use Chenhua\MarkdownEditor\Facades\MarkdownEditor;

class IndexController extends Controller
{
    protected static $bannerID = 1;
    protected static $articlePID = 1;

    /**
     * @param ArticleRepository $articleRepository
     * @return mixed
     */
    public function getArticle(ArticleRepository $articleRepository)
    {
        return $articleRepository->list();
    }

    /**
     * @param ArticleRepository $articleRepository
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public function getArticleContent(ArticleRepository $articleRepository, $id)
    {
        try {
            $data = $articleRepository->find($id, true);
        } catch (\Exception $exception) {
            return response('', 404);
        }

        $data = $data->toArray();
        $data['content'] = $data['content']['content'];
        if ($data['is_md']) {
            $data['content'] = MarkdownEditor::parse($data['content']);
        }
        return $data;
    }

    /**
     * @param AdRepository $adRepository
     * @return mixed
     */
    public function getBanner(AdRepository $adRepository)
    {
        return $adRepository->find(self::$bannerID)->ad;
    }

    /**
     * @param CategoryRepository $categoryRepository
     * @return mixed
     */
    public function getCategory(CategoryRepository $categoryRepository)
    {
        $where = [
            'pid' => self::$articlePID
        ];
        return $categoryRepository->listBy($where, false);
    }

    /**
     * @param SinglePageRepository $singlePageRepository
     * @param $id
     * @return array|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|\Symfony\Component\HttpFoundation\Response|static|static[]
     */
    public function getSinglePage(SinglePageRepository $singlePageRepository, $id)
    {
        try {
            $data = $singlePageRepository->find($id, true);
        } catch (\Exception $exception) {
            return response('', 404);
        }

        $data = $data->toArray();
        $data['content'] = $data['content']['content'];
        if ($data['is_md']) {
            $data['content'] = MarkdownEditor::parse($data['content']);
        }
        return $data;
    }
}