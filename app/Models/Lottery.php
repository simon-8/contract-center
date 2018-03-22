<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/3/20
 * Time: 23:09
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    public $table = 'lottery';

    protected $fillable = [
        'apply_id',
        'userid',
        'aid',
        'gid',
        'gname',
        'truename',
        'mobile',
        'admin_userid'
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

    public function Apply()
    {
        return $this->belongsTo('App\Models\LotteryApply', 'apply_id', 'id');
    }

    public function Gift()
    {
        return $this->belongsTo('App\Models\Gift', 'gid', 'id');
    }
}