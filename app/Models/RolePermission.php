<?php
/**
 * Note: 角色权限关联表
 * User: Liu
 * Date: 2018/11/20
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RolePermission
 *
 * @property string $role_id 角色ID
 * @property string $access_id 权限ID
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RolePermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RolePermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RolePermission query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RolePermission whereAccessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RolePermission whereRoleId($value)
 * @mixin \Eloquent
 */
class RolePermission extends Model
{
    public $table = 'role_permission';

    public $timestamps = false;

    public $fillable = [
        'role_id',
        'access_id'
    ];

}