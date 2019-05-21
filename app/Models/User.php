<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
        'nickname',
        'mobile',
        'email',
        'money',
        'city',
        'province',
        'country',
        'avatar',
        'gender',
        'client_id',
        'last_login_time',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeOfCreatedAt($query, $data = '')
    {
        if ($data === '') return $query;
        if (is_array($data)) {
            $start = $data[0];
            $end = $data[1];
        } else if (strpos($data, ' - ') !== false) {
            list($start, $end) = explode(' - ', $data);
        } else {
            $start = date('Y-m-d 00:00:00', strtotime($data));
            $end = date('Y-m-d 00:00:00', strtotime($start) + 86400);
        }
        return $query->where('created_at', '>=', $start)->where('created_at', '<', $end);
    }

    public function scopeOfType($query, $type = '')
    {
        if ($type === '') {
            return $query;
        }
        return $query->where('type', $type);
    }
}
