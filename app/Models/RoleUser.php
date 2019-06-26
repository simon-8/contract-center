<?php
/**
 * Note: 用户权限关联表
 * User: Liu
 * Date: 2018/11/20
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RoleUser
 *
 * @property int $user_id 用户ID
 * @property int $role_id 角色ID
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoleUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoleUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoleUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoleUser whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoleUser whereUserId($value)
 * @mixin \Eloquent
 */
class RoleUser extends Model
{
    public $table = 'role_user';

    public $timestamps = false;

    public $fillable = [
        'user_id',
        'role_id'
    ];
}