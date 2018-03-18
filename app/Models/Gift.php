<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    protected $fillable = [
        'aid',
        'name',
        'introduce',
        'thumb',
        'amount',
        'sales',
        'status'
    ];

    //public function getStartTimeAttribute($value)
    //{
    //    return date('Y-m-d H:i:s', $value);
    //}
    //
    //public function setStartTimeAttribute($value)
    //{
    //    $this->attributes['start_time'] = strtotime($value);
    //}
    //
    //public function getEndTimeAttribute($value)
    //{
    //    return date('Y-m-d H:i:s', $value);
    //}
    //
    //public function setEndTimeAttribute($value)
    //{
    //    $this->attributes['end_time'] = strtotime($value);
    //}
}
