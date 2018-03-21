<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    public $table = 'activity';

    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'actor',
        'max_actor',
        'status'
    ];

    public function getStartTimeAttribute($value)
    {
        return date('Y-m-d H:i:s', $value);
    }

    public function setStartTimeAttribute($value)
    {
        $this->attributes['start_time'] = strtotime($value);
    }

    public function getEndTimeAttribute($value)
    {
        return date('Y-m-d H:i:s', $value);
    }

    public function setEndTimeAttribute($value)
    {
        $this->attributes['end_time'] = strtotime($value);
    }

    /**
     * 活动对应的广告位
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function AdPlace()
    {
        return $this->hasOne('App\Models\AdPlace', 'aid', 'id');
    }

    /**
     * 活动对应的奖品
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function Gift()
    {
        return $this->hasMany('App\Models\Gift', 'aid', 'id');
    }

    /**
     * 活动对应的用户
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    //public function User()
    //{
    //    return $this->hasMany('App\Models\User');
    //}

    /**
     * 活动对应的抽奖记录
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function LotteryApply()
    {
        return $this->hasMany('App\Models\LotteryApply', 'aid', 'id');
    }

    /**
     * 活动对应的中奖记录
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Lottery()
    {
        return $this->hasMany('App\Models\Lottery', 'aid', 'id');
    }
}
