<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/6/27
 * Time: 22:58
 */
namespace App\Models;

class UserAddress extends Base
{
    protected $table = 'user_address';

    protected $fillable = [
        'userid',
        'linkman',
        'mobile',
        'country',
        'province',
        'city',
        'address',
        'postcode',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'userid', 'id');
    }

    /**
     * 查询联系人
     * @param $query
     * @param string $data
     * @return mixed
     */
    public function scopeOfLinkman($query, $data = '')
    {
        if (!$data) return $query;
        return $query->where('linkman', 'like', '%'. $data .'%');
    }
}