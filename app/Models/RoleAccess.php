<?php
/**
 * Note: 权限
 * User: Liu
 * Date: 2018/4/20
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleAccess extends Model
{
    public $table = 'role_access';

    public $timestamps = false;

    public $fillable = [
        'pid',
        'name',
        'method',
        'path'
    ];

    public function getMethodAttribute($value)
    {
        return $value ? explode(',', $value) : [];
    }

    public function setMethodAttribute($value)
    {
        $this->attributes['method'] = $value ? implode(',', $value) : '';
    }

    public function child()
    {
        return $this->hasMany('App\Models\Admin\RoleAccess', 'pid', 'id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Modles\Admin\RoleAccess', 'pid', 'id');
    }
}