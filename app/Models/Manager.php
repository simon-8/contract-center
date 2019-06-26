<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/11/1
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User AS Authenticatable;
//use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\Manager
 *
 * @property int $id
 * @property string $username 用户名
 * @property string $password 密码
 * @property string $truename 真实姓名
 * @property string $email 邮箱号码
 * @property int $is_admin 是否管理员
 * @property string $role 权限列表
 * @property string $avatar 头像
 * @property string $lastip 上一次登录ip
 * @property string $lasttime 最后登录时间
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manager newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manager newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manager query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manager whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manager whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manager whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manager whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manager whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manager whereLastip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manager whereLasttime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manager wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manager whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manager whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manager whereTruename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manager whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Manager whereUsername($value)
 * @mixin \Eloquent
 */
class Manager extends Authenticatable
{
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