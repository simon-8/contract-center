<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/3/22
 * Time: 03:09
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LotteryApply extends Model
{
    public $table = 'lottery_apply';

    protected $fillable = [
        'aid',
        'userid',
        'truename',
        'mobile',
    ];

    /**
     * 对应用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function User()
    {
        return $this->belongsTo('App\Models\User', 'userid', 'id');
    }

    /**
     * 对应活动
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Activity()
    {
        return $this->belongsTo('App\Models\Activity', 'aid', 'id');
    }

    public function Lottery()
    {
        return $this->hasOne('App\Models\Lottery', 'apply_id', 'id');
    }
}