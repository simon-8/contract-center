<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/6/27
 * Time: 22:58
 */
namespace App\Models;

/**
 * App\Models\UserAddress
 *
 * @property int $id
 * @property int $userid 用户ID
 * @property string $linkman 联系人
 * @property string $mobile 联系电话
 * @property string $country 国家
 * @property string $province 省
 * @property string $city 城市
 * @property string $address 地址
 * @property string $postcode 邮编
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed $areaid
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofCatid($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofCreatedAt($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress ofLinkman($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofStatus($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofUserid($data = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress whereLinkman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress whereUserid($value)
 * @mixin \Eloquent
 * @property string $area 区县
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress whereAreaid($value)
 */
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