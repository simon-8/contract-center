<?php
/**
 * Note: 广告位
 * User: Liu
 * Date: 2018/3/12
 * Time: 22:11
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

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