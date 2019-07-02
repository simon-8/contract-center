<?php
/**
 * Note: E签名用户关联表
 * User: Liu
 * Date: 2019/7/2
 */
namespace App\Models;

class EsignUser extends Base
{
    protected $table = 'esign_user';

    protected $fillable = [
        'accountid',
        'userid',
    ];

    public $timestamps = false;

    /**
     * 关联用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'userid', 'id');
    }
}