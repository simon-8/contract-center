<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/3/21
 * Time: 20:50
 */
namespace App\Observers;

use App\Models\Article;
use App\Models\ArticleContent;

class ArticleObserver
{
    /**
     * 删除时删除对应内容
     * @param Article $article
     * @throws \Exception
     */
    public function deleted(Article $article)
    {
        $content = $article->content()->first();
        $content->delete();
        $article->tags()->detach();
    }
}