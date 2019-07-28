<?php
/**
 * Note: 用户权限关联表
 * User: Liu
 * Date: 2018/11/20
 */
namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    use ModelTrait;

    public $table = 'role_user';

    public $timestamps = false;

    public $fillable = [
        'user_id',
        'role_id'
    ];
}
