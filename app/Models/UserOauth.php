<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserOauth extends Model
{
    protected $table = 'user_oauth';

    protected $fillable = [
        'userid',
        'openid',
        'unionid',
        'channel',
        'client_id',
    ];

    //public $incrementing = false;

    //protected $primaryKey = 'userid';
}
