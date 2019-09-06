<?php
/**
 * Note: 广告
 * User: Liu
 * Date: 2018/3/12
 * Time: 21:56
 */
namespace App\Models;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use ModelTrait;

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

    //public function getThumbAttribute($value)
    //{
    //    return $value ? imgurl($value) : '';
    //}

    /**
     * 广告对应广告位
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function adPlace()
    {
        return $this->belongsTo('App\Models\AdPlace', 'pid', 'id');
    }

    /**
     * @param $query
     * @param int $data
     * @return int
     */
    public function scopeOfPid($query, $data = 0)
    {
        if (empty($data)) return $data;
        return $query->where('pid', $data);
    }
}
