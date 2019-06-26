<?php
/**
 * Note: 角色
 * User: Liu
 * Date: 2018/11/14
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name 角色名称
 * @property string $access 权限ID集合
 * @property int $status 状态
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RoleAccess[] $roleAccess
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereStatus($value)
 * @mixin \Eloquent
 */
class Role extends Model
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