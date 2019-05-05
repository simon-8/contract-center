<?php
/**
 * Note: 广告
 * User: Liu
 * Date: 2018/3/12
 * Time: 21:56
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    public $table = 'ad';

    protected $fillable = [
        'id',
        'pid',
        'thumb',
        'url',
        'title',
        'content',
        'listorder'
    ];

    public function getThumbAttribute($value)
    {
        return $value ? imgurl($value) : '';
    }

    /**
     * 广告对应广告位
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function adPlace()
    {
        return $this->belongsTo('App\Models\AdPlace', 'pid', 'id');
    }
}