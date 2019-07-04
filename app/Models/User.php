<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $username 用户名
 * @property string $password 密码
 * @property string $nickname 昵称
 * @property string $mobile 手机号码
 * @property string $email email
 * @property float $money 余额
 * @property string $city 国家
 * @property string $province 省份
 * @property string $country 城市
 * @property string $avatar 头像
 * @property int $gender 1男2女0未知
 * @property int $client_id 所属客户端 ID
 * @property string $last_login_time 最后登录时间
 * @property int $is_block 是否冻结
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserOauth[] $userOauth
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User ofCreatedAt($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User ofMobile($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User ofNickname($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User ofUsername($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIsBlock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastLoginTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereMoney($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUsername($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserAddress[] $address
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserOauth[] $oauth
 * @property-read \App\Models\EsignUser $esignUser
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    const CLIENT_ID_MINI_PROGRAM = 2;// 微信小程序
    const CLIENT_ID_WECHAT = 3;// 微信公众号

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
    public function oauth()
    {
        return $this->hasMany('App\Models\UserOauth', 'userid', 'id');
    }

    /**
     * 收货地址
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function address()
    {
        return $this->hasMany('App\Models\UserAddress', 'userid', 'id');
    }

    /**
     * E签名关联用户
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function esignUser()
    {
        return $this->hasOne('App\Models\EsignUser', 'userid', 'id');
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
        $userOauth = $this->oauth()->where('channel', 'miniprogram')->first();
        return $userOauth ? $userOauth->openid : null;
    }

    /**
     * 微信公众号openid
     * @return mixed|null
     */
    public function wechatOpenid()
    {
        $userOauth = $this->oauth()->where('channel', 'wechat')->first();
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
