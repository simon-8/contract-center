<?php
/**
 * Note: 分类资源库
 * User: Liu
 * Date: 2018/4/9
 */
namespace App\Repositories;

use App\Models\Category;

class CategoryRepository extends BaseRepository
{
    public function __construct(Category $category)
    {
        parent::__construct($category);
    }

    public function listByPID($pid)
    {
        return $this->lists(['pid' => $pid], false)->toArray();
    }
}