<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/6/27
 * Time: 22:58
 */
namespace App\Models;

use App\Traits\ModelTrait;

class UserAddress extends Base
{
    use ModelTrait;

    protected $table = 'user_address';

    protected $fillable = [
        'userid',
        'linkman',
        'mobile',
        'country',
        'province',
        'city',
        'area',
        'areaid',
        'address',
        'postcode',
    ];

    /**
     * @param $value
     * @return mixed
     */
    public function getAreaidAttribute($value)
    {
        return json_decode($value, true);
    }

    /**
     * @param $value
     */
    public function setAreaidAttribute($value)
    {
        $this->attributes['areaid'] = json_encode($value);
    }

    /**
     * 关联用户
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
