<?php
/**
 * Note: 文章详情
 * User: Liu
 * Date: 2018/4/3
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleContent extends Model
{
    public $table = 'article_content';

    public $timestamps = false;

    public $fillable = [
        'id',
        'content'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo('App\Models\Article', 'id', 'id');
    }
}