<?php
/**
 * Note: 广告
 * User: Liu
 * Date: 2018/3/12
 * Time: 22:11
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AdPlace extends Model
{
    protected $fillable = [
        'id',
        'pid',
        'thumb',
        'url',
        'title',
        'content',
        'listorder'
    ];
}