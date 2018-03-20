<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $table = 'user';

    protected $fillable = [
        'openid',
        'truename',
        'mobile',
        'nickname',
        'avatar',
        'language',
        'city',
        'province',
        'country',
        'unionid',
        'subscribed_at',
    ];

    public function Lottery()
    {
        return $this->hasMany('App\Models\Lottery', 'userid', 'id');
    }
}
