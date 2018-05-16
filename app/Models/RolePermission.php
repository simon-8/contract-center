<?php
/**
 * Note: 角色权限关联表
 * User: Liu
 * Date: 2018/4/20
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    public $table = 'role_permission';

    public $timestamps = false;

    public $fillable = [
        'role_id',
        'access_id'
    ];

}