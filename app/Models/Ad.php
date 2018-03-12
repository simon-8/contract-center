<?php
/**
 * Note: 广告位
 * User: Liu
 * Date: 2018/3/12
 * Time: 21:56
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'width',
        'height',
        'status'
    ];
}