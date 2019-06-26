<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
        'nickname',
        'mobile',
        'email',
        'money',
        'city',
        'province',
        'country',
        'avatar',
        'gender',
        'client_id',
        'last_login_time',
        //'is_block',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * oauth关系
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userOauth()
    {
        return $this->hasMany('App\Models\UserOauth', 'userid', 'id');
    }

    /**
     * 匹配小程序  PassPort使用id做用户名
     * 其他应用同上
     * @param $username
     * @return mixed
     */
    public function findForPassport($username)
    {
        return $this->find($username);
    }

    /**
     * 小程序openid
     * @return mixed
     */
    public function miniGameOpenid()
    {
        $userOauth = $this->userOauth()->where('channel', 'miniprogram')->first();
        return $userOauth ? $userOauth->openid : null;
    }

    /**
     * 微信公众号openid
     * @return mixed|null
     */
    public function wechatOpenid()
    {
        $userOauth = $this->userOauth()->where('channel', 'wechat')->first();
        return $userOauth ? $userOauth->openid : null;
    }


    /**
     * @param $query
     * @param string $data
     * @return mixed
     */
    public function scopeOfCreatedAt($query, $data = '')
    {
        if ($data === '') return $query;
        if (is_array($data)) {
            $start = $data[0];
            $end = $data[1];
            $end = date('Y-m-d', strtotime($end) + 86400);
        } else if (strpos($data, ' - ') !== false) {
            list($start, $end) = explode(' - ', $data);
            $end = date('Y-m-d', strtotime($end) + 86400);
        } else {
            $start = date('Y-m-d', strtotime($data));
            $end = date('Y-m-d', strtotime($start) + 86400);
        }
        return $query->where('created_at', '>=', $start)->where('created_at', '<', $end);
    }

    /**
     * @param $query
     * @param string $data
     * @return mixed
     */
    public function scopeOfUsername($query, $data = '')
    {
        if ($data === '') {
            return $query;
        }
        return $query->where('username', $data);
    }

    /**
     * @param $query
     * @param string $data
     * @return mixed
     */
    public function scopeOfMobile($query, $data = '')
    {
        if ($data === '') {
            return $query;
        }
        return $query->where('mobile', $data);
    }

    /**
     * @param $query
     * @param string $data
     * @return mixed
     */
    public function scopeOfNickname($query, $data = '')
    {
        if ($data === '') {
            return $query;
        }
        return $query->where('nickname', 'like', '%'.$data.'%');
    }
}
