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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function manager()
    {
        return $this->hasMany('App\Models\Manager', 'groupid', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roleAccess()
    {
        return $this->hasMany('App\Models\RoleAccess', 'id', 'access');
    }
}