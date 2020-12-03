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
        return $this->belongsTo('App\Models\User', 'userid', 'id');
    }

    /**
     * 获取微信渠道
     * @return string[]
     */
    public static function getWechatChannels()
    {
        return [
            self::CHANNEL_WECHAT,
            self::CHANNEL_WECHAT_MINI,
            self::CHANNEL_WECHAT_OFFICIAL,
        ];
    }

    /**
     * 获取微信登录用户ID
     * @param string $unionid
     * @return int|mixed
     */
    public static function getUseridByWechat(string $unionid)
    {
        return self::where('userid', '>', 0)
            ->where('unionid', $unionid)
            ->whereIn('channel', self::getWechatChannels())
            ->value('userid') ?: 0;
    }

    /**
     * 根据unionid更新userid
     * @param string $unionid
     * @param $userid
     * @param array $channels
     */
    public static function updateUseridByUnionid(string $unionid, $userid, array $channels)
    {
        self::whereIn('channel', $channels)
            ->where('unionid', $unionid)
            ->where('userid', 0)
            ->update(['userid' => $userid]);
    }
}
