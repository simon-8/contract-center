<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/6/30
 * Time: 13:35
 */
namespace App\Models;

class UserSign extends Base
{
    protected $table = 'user_sign';

    protected $fillable = [
        'contrct_id',
        'userid',
        'thumb',
    ];

    /**
     * 关联用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'userid', 'id');
    }


}