<?php
/**
 * Note: 角色
 * User: Liu
 * Date: 2018/11/14
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    public $table = 'roles';

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

    public function setAccessAttribute($value = null)
    {
        $this->attributes['access'] = $value ? implode(',', $value) : '';
    }

    public function setStatusAttribute($value = null)
    {
        $this->attributes['status'] = $value ?? 0;
    }

    /**
     * 权限关联
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roleAccess()
    {
        return $this->belongsToMany('App\Models\RoleAccess', 'role_permission', 'role_id', 'access_id');
    }
}