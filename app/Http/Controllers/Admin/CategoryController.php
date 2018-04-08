<?php
/**
 * Note: 分类
 * User: Liu
 * Date: 2018/4/4
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Category;

class CategoryController extends Controller
{
    public function getIndex(Category $category)
    {

        $categorys = $category::with('childCategory')->first();
        dd(

            $categorys
        );
    }

    public function doCreate()
    {

    }

    public function doUpdate()
    {

    }
}