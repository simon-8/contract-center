<?php
/**
 * Note: 点击数纪录
 * User: Liu
 * Date: 2018/4/3
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HitRecord extends Model
{
    public $table = 'hit_records';

    public $fillable = [
        'mid',
        'catid',
        'aid',
        'hits'
    ];

}