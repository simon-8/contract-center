<?php
/**
 * Note: 广告位
 * User: Liu
 * Date: 2018/3/12
 * Time: 22:11
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AdPlace
 *
 * @property int $id
 * @property string $name 广告位名称
 * @property int $width 广告位宽度
 * @property int $height 广告位高度
 * @property int $status 广告位状态
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ad[] $ad
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdPlace newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdPlace newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdPlace query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdPlace whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdPlace whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdPlace whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdPlace whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdPlace whereWidth($value)
 * @mixin \Eloquent
 */
class AdPlace extends Model
{
    public $table = 'ad_place';

    // 默认宽度
    public static $defaultWidth = 640;
    // 默认高度
    public static $defaultHeight = 350;

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = [
        'id',
        'aid',
        'name',
        'width',
        'height',
        'status'
    ];

    /**
     * 广告位中的广告
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ad()
    {
        return $this->hasMany('App\Models\Ad', 'pid', 'id');
    }
}