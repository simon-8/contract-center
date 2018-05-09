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
    
    public function member()
    {
        return $this->hasMany('App\Models\Manager', 'groupid', 'id');
    }
}