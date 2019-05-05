<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Manager extends Authenticatable
{
    public $table = 'manager';

    protected $fillable = [
        'username',
        'password',
        'truename',
        'email',
        //'is_admin',
        'avatar',
        'role',
        'salt',
        'lasttime',
        'lastip',
        'remember_token',
    ];

    public function getRoleAttribute($value)
    {
        return $value ? explode(',', $value) : [];
    }

    public function setRoleAttribute($value)
    {
        $this->attributes['role'] = $value ? implode(',', $value) : '';
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = password_hash($value , PASSWORD_DEFAULT);
    }

    public function getAvatar($value)
    {
        $this->attributes['avatar'] = imgurl($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Roles', 'role_user', 'user_id', 'role_id');
    }
}
