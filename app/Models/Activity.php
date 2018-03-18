<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    public $table = 'activity';

    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'actor',
        'max_actor',
        'status'
    ];

    public function getStartTimeAttribute($value)
    {
        return date('Y-m-d H:i:s', $value);
    }

    public function setStartTimeAttribute($value)
    {
        $this->attributes['start_time'] = strtotime($value);
    }

    public function getEndTimeAttribute($value)
    {
        return date('Y-m-d H:i:s', $value);
    }

    public function setEndTimeAttribute($value)
    {
        $this->attributes['end_time'] = strtotime($value);
    }
}
