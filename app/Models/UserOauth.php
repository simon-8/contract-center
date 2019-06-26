<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\UserOauth
 *
 * @property int $id
 * @property int $userid
 * @property string $openid OPENID
 * @property string $unionid UNIONID
 * @property string $channel 渠道
 * @property int $client_id 客户端ID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserOauth newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserOauth newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserOauth query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserOauth whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserOauth whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserOauth whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserOauth whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserOauth whereOpenid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserOauth whereUnionid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserOauth whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserOauth whereUserid($value)
 * @mixin \Eloquent
 */
class UserOauth extends Model
{
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
}
