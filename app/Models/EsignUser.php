<?php
/**
 * Note: E签名用户关联表
 * User: Liu
 * Date: 2019/7/2
 */
namespace App\Models;

use App\Traits\ModelTrait;

class EsignUser extends Base
{
    use ModelTrait;

    protected $table = 'esign_user';

    protected $fillable = [
        'accountid',
        'userid',
        'type',// 用户类型 0个人 1公司
    ];

    public $timestamps = false;

    const TYPE_PERSON = 0;
    const TYPE_COMPANY = 1;

    /**
     * 关联用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'userid', 'id');
    }

    /**
     * 类型查询
     * @param $query
     * @param string $data
     * @return mixed
     */
    public function scopeOfType($query, $data = '')
    {
        if ($data === '') return $query;
        return $query->where('type', $data);
    }
}
