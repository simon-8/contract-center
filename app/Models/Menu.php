<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/3/11
 * Time: 18:01
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = [
        'pid',
        'name',
        'route',
        'link',
        'ico',
        'listorder',
        'items',
    ];

}