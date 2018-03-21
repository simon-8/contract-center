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
        'level',
        'amount',
        'sales',
        'status'
    ];

    public function getThumbAttribute($value)
    {
        return imgurl($value);
    }

    public function Activity()
    {
        return $this->belongsTo('App\Models\Activity', 'aid', 'id');
    }

    public function Lottery()
    {
        return $this->hasOne('App\Models\Lottery', 'gid', 'id');
    }
}
