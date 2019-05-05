<?php
/**
 * Note: 单页
 * User: Liu
 * Date: 2018/4/11
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SinglePage extends Model
{
    public $table = 'single_page';

    public $fillable = [
        'catid',
        'title',
        'thumb',
        'username',
        'comment',
        'zan',
        'hits',
        'is_md',
        'status'
    ];

    /**
     * @param $value
     * @return string
     */
    public function getThumbAttribute($value)
    {
        return imgurl($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function content()
    {
        return $this->hasOne('App\Models\SinglePageContent', 'id', 'id');
    }
}