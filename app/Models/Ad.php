<?php
/**
 * Note: 广告
 * User: Liu
 * Date: 2018/3/12
 * Time: 21:56
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Ad
 *
 * @property int $id
 * @property int $pid 所属广告位ID
 * @property string $thumb 图片
 * @property string $url 外链地址
 * @property string $title 图片名称
 * @property string $content 文字介绍
 * @property int $listorder 排序
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AdPlace $adPlace
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad ofPid($data = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereListorder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereThumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereUrl($value)
 * @mixin \Eloquent
 */
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