<?php
/**
 * Note: 权限组
 * User: Liu
 * Date: 2018/4/20
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleGroup extends Model
{
    public $table = 'role_group';

    public $timestamps = false;

    public $fillable = [
        'name',
        'access',
        'status'
    ];

    public function getAccessAttribute($value)
    {
        return $value ? explode(',', $value) : [];
    }

    public function setAccessAttribute($value)
    {
        $this->attributes['access'] = $value ? implode(',', $value) : '';
    }
    
    public function getUsers()
    {
        return $this->hasMany('App\Models\Manager', 'groupid', 'id');
    }

    public function getAccess()
    {
        return $this->hasMany('App\Models\RoleAccess', 'id', 'access');
    }
}