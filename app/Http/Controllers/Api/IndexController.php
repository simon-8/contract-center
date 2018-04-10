<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/4/10
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\ArticleRepository;
use App\Repositories\AdRepository;
use App\Repositories\CategoryRepository;

class IndexController extends Controller
{
    /**
     * @param ArticleRepository $articleRepository
     * @return mixed
     */
    public function getArticle(ArticleRepository $articleRepository)
    {
        return $articleRepository->list();
    }

    /**
     * @param AdRepository $adRepository
     * @return mixed
     */
    public function getBanner(AdRepository $adRepository)
    {
        return $adRepository->find(1)->ad;
    }

    /**
     * @param CategoryRepository $categoryRepository
     * @return mixed
     */
    public function getCategory(CategoryRepository $categoryRepository)
    {
        return $categoryRepository->listBy([
            'pid' => 1
        ], false);
    }
}