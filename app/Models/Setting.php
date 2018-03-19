<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //设置自定义主键
    public $primaryKey = 'item';

    public $incrementing = false;

    protected $fillable = [
        'item',
        'name',
        'value',
    ];

    //禁止维护timestamps相关字段
    public $timestamps = false;
}
