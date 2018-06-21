<?php
/**
 * Note: 首页所需接口
 * User: Liu
 * Date: 2018/4/10
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\AdRepository;
use App\Repositories\CategoryRepository;

use App\Models\Tag;
use App\Repositories\SinglePageRepository;

class IndexController extends Controller
{
    protected static $bannerID = 1;
    protected static $articlePID = 1;

    /**
     * banner
     * @param AdRepository $adRepository
     * @return mixed
     */
    public function getBanner(AdRepository $adRepository)
    {
        return $adRepository->find(self::$bannerID)->ad;
    }

    /**
     * 分类
     * @param CategoryRepository $categoryRepository
     * @return mixed
     */
    public function getCategory(CategoryRepository $categoryRepository)
    {
        $where = [
            'pid' => self::$articlePID
        ];
        return $categoryRepository->lists($where, false);
    }

    /**
     * 获取标签
     * @param Tag $tag
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getTag(Tag $tag)
    {
        return $tag::all(['id', 'name']);
    }

    /**
     * 获取菜单
     * @param CategoryRepository $categoryRepository
     * @param SinglePageRepository $singlePageRepository
     * @return array
     */
    public function getMenus(CategoryRepository $categoryRepository, SinglePageRepository $singlePageRepository)
    {
        $categorys = $this->getCategory($categoryRepository);
        if ($categorys) {
            $categorys->transform(function($category) {
                return [
                    'id' => $category['id'],
                    'name' => $category['name']
                ];
            });
        }
        //$singles = $singlePageRepository->listBy(['status' => 1], false);
        //if ($singles) {
        //    $singles->transform(function($single) {
        //        return [
        //            'id' => $single['id'],
        //            'name' => $single['title']
        //        ];
        //    });
        //}
        return [
            'categorys' => $categorys,
            //'singles'   => $singles
        ];
    }
}