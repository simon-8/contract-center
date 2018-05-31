<?php
/**
 * Note: 文章
 * User: Liu
 * Date: 2018/4/3
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public $table = 'article';

    public $fillable = [
        'catid',
        'title',
        'introduce',
        'thumb',
        'username',
        'comment',
        'zan',
        'hits',
        'is_md',
        'status'
    ];

    public function getThumbAttribute($value)
    {
        return $value ? imgurl($value) : '';
    }

    /**
     * 查询作用域
     * @param $query
     * @param $title
     * @return mixed
     */
    public function scopeTitle($query, $title)
    {
        return $query->where('title', 'like', '%'. $title .'%');
    }

    /**
     * 内容关联
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function content()
    {
        return $this->hasOne('App\Models\ArticleContent', 'id', 'id');
    }

    /**
     * 分类关联
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->hasOne('App\Models\Category', 'id', 'catid');
    }

    /**
     * 标签关联
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        //
        return $this->belongsToMany('App\Models\Tag')->withTimestamps();
    }
}