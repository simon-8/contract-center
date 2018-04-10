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
        'status'
    ];

    public function content()
    {
        return $this->hasOne('App\Models\ArticleContent', 'id', 'id');
    }

    public function category()
    {
        return $this->hasOne('App\Models\Category', 'id', 'catid');
    }

    public function scopeTitle($query, $title)
    {
        return $query->where('title', 'like', '%'. $title .'%');
    }

    public function getThumbAttribute($value)
    {
        return imgurl($value);
    }
}