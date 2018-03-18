<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    public $table = 'manager';

    protected $fillable = [
        'username',
        'password',
        'truename',
        'email',
        'is_admin',
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
}
