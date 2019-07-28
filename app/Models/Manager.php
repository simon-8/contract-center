<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/11/1
 */
namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User AS Authenticatable;
//use Spatie\Permission\Traits\HasRoles;

class Manager extends Authenticatable
{
    use ModelTrait;

    //use HasRoles;
    protected $guard_name = 'admin';

    protected $table = 'manager';

    protected $fillable = [
        'username',
        'password',
        'truename',
        'email',
        'is_admin',
        'avatar',
        'role',
        'salt',
        'lasttime',
        'lastip',
        'remember_token',
    ];

    public function getRoleAttribute($value)
    {
        return $value ? explode(',', $value) : [];
    }

    public function setRoleAttribute($value)
    {
        $this->attributes['role'] = $value ? implode(',', $value) : '';
    }

    /**
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = password_hash($value , PASSWORD_DEFAULT);
    }

    /**
     * @param $value
     */
    public function getAvatar($value)
    {
        $this->attributes['avatar'] = imgurl($value);
    }

    /**
     * 管理员权限
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'role_user', 'user_id', 'role_id');
    }

}
