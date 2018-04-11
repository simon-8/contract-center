<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/3/21
 * Time: 20:50
 */
namespace App\Observers;

use App\Models\SinglePage;
use App\Models\SinglePageContent;

class SinglePageObserver
{
    /**
     * 删除时删除对应内容
     * @param SinglePage $singlePage
     * @throws \Exception
     */
    public function deleted(SinglePage $singlePage)
    {
        $content = $singlePage->content()->first();
        $content->delete();
    }
}