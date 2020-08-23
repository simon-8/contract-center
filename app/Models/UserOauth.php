<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserOauth extends Model
{
    use ModelTrait;

    public const CHANNEL_WECHAT = 'wechat';// 微信开放平台 APP登录/网页登录
    public const CHANNEL_WECHAT_MINI = 'miniprogram';// 微信小程序
    public const CHANNEL_WECHAT_OFFICIAL = 'mp_official';// 微信公众号

    protected $table = 'user_oauth';

    protected $fillable = [
        'userid',
        'openid',
        'unionid',
        'channel',
        'client_id',
    ];
    //public $incrementing = false;

    //protected $primaryKey = 'userid';

    /**
     * 关联用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\UserOauth', 'userid', 'id');
    }
}
