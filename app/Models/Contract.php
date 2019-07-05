<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Contract
 *
 * @property int $id
 * @property string $name 合同名称
 * @property int $catid 合同分类
 * @property int $userid 关联用户ID
 * @property int $targetid 目标用户ID
 * @property int $lawyerid 关联律师ID
 * @property int $mycatid 我的分类(文件夹)
 * @property string $jiafang 甲方
 * @property string $yifang 乙方
 * @property string $jujianren 居间人
 * @property int $confirm_first
 * @property int $confirm_second
 * @property int $status 状态
 * @property string $confirm_at 确认时间
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ContractContent $content
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ContractFile[] $file
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract ofCatid($data = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract ofJiafang($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract ofJujianren($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract ofLawyerid($data = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract ofMycatid($data = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract ofStatus($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract ofUserid($data = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract ofYifang($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereCatid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereConfirmAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereJiafang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereJujianren($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereLawyerid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereMycatid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereTargetConfirm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereTargetid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereUserConfirm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereUserid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereYifang($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract ofTargetid($data = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract ofCreatedAt($data = '')
 * @property-read \App\Models\Order $order
 * @property-read \App\Models\User $target
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Sign[] $sign
 * @property int $signed_first 用户已签名
 * @property int $signed_second 对方已签名
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereTargetSigned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereUserSigned($value)
 * @property int $userid_first 甲方用户ID
 * @property int $userid_second 乙方用户ID
 * @property int $userid_three 居间人用户ID
 * @property int $confirm_three 居间人是否已确认
 * @property int $signed_three 居间人是否已签名
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereConfirmFirst($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereConfirmSecond($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereConfirmThree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereSignedFirst($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereSignedSecond($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereSignedThree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereUseridFirst($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereUseridSecond($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract whereUseridThree($value)
 */
class Contract extends Base
{
    protected $table = 'contract';

    protected $fillable = [
        'name',
        'catid',
        'userid',
        'lawyerid',
        'mycatid',
        'jiafang',
        'yifang',
        'jujianren',

        'userid_first',
        'userid_second',
        'userid_three',

        'confirm_first',
        'confirm_second',
        'confirm_three',

        'signed_first',
        'signed_second',
        'signed_three',

        'status',
        'confirm_at',
    ];

    const STATUS_APPLY = 0;
    const STATUS_CONFIRM = 1;
    const STATUS_PAYED = 2;
    const STATUS_SIGN = 3;

    // 用户类型 first甲 second乙 three居间
    const USER_TYPE_FIRST = 'first';
    const USER_TYPE_SECOND = 'second';
    const USER_TYPE_THREE = 'three';

    const CAT_NORMAL = 0;
    const CAT_DOUBLE = 1;
    const CAT_THREE = 2;

    /**
     * 关联内容
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function content()
    {
        return $this->hasOne('App\Models\ContractContent', 'id', 'id');
    }

    /**
     * 关联资源
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function file()
    {
        return $this->hasMany('App\Models\ContractFile', 'contract_id', 'id');
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
     * 关联目标用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    //public function target()
    //{
    //    return $this->belongsTo('App\Models\User', 'targetid', 'id');
    //}

    /**
     * 关联订单
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'contract_id', 'id');
    }

    /**
     * 关联签名
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sign()
    {
        return $this->hasMany('App\Models\Sign', 'contract_id', 'id');
    }

    /**
     * 对方用户ID
     * @param $query
     * @param int $data
     * @return mixed
     */
    //public function scopeOfTargetid($query, $data = 0)
    //{
    //    if (!$data) return $query;
    //    return $query->where('targetid', $data);
    //}

    /**
     * 律师id
     * @param $query
     * @param int $data
     * @return mixed
     */
    public function scopeOfLawyerid($query, $data = 0)
    {
        if (!$data) return $query;
        return $query->where('lawyerid', $data);
    }

    /**
     * 用户分类
     * @param $query
     * @param int $data
     * @return mixed
     */
    public function scopeOfMycatid($query, $data = 0)
    {
        if (!$data) return $query;
        return $query->where('mycatid', $data);
    }

    /**
     * 甲方
     * @param $query
     * @param string $data
     * @return mixed
     */
    public function scopeOfJiafang($query, $data = '')
    {
        if (!$data) return $query;
        return $query->where('jiafang', $data);
    }

    /**
     * 居间人
     * @param $query
     * @param string $data
     * @return mixed
     */
    public function scopeOfJujianren($query, $data = '')
    {
        if (!$data) return $query;
        return $query->where('jujianren', $data);
    }

    /**
     * 乙方
     * @param $query
     * @param string $data
     * @return mixed
     */
    public function scopeOfYifang($query, $data = '')
    {
        if (!$data) return $query;
        return $query->where('yifang', $data);
    }

    /**
     * 获取分类
     * @return array
     */
    public function getCats()
    {
        $cats = [
            self::CAT_NORMAL => '通用',
            self::CAT_DOUBLE => '两方',
            self::CAT_THREE => '三方',
        ];
        return $cats;
    }

    /**
     * 获取分类名
     * @param $catid
     * @return mixed|string
     */
    public function getCatText($catid = null)
    {
        if ($catid === null) $catid = $this->catid;
        return $this->getCats()[$catid] ?? 'not found';
    }

    /**
     * 获取状态数组
     * @param null $status
     * @return array
     */
    public function getStatus()
    {
        $statusArr = [
            self::STATUS_APPLY => '已申请',
            self::STATUS_CONFIRM => '已确认',
            self::STATUS_PAYED => '已支付',
            self::STATUS_SIGN => '已签名'
        ];
        return $statusArr;
    }

    /**
     * 获取文本
     * @param null $status
     * @return mixed|string
     */
    public function getStatusText($status = null)
    {
        if ($status === null) $status = $this->status;
        return $this->getStatus()[$status] ?? 'not found';
    }

    /**
     * 是否是拥有者
     * @param $userid
     * @return bool
     */
    public function isOwner($userid)
    {
        return $this->userid == $userid;
    }

    /**
     * 获取用户类型
     * first 甲
     * second 乙
     * three 居间人
     * @param $type
     * @return string
     */
    public function getUserType($type)
    {
        $userType = 'first';
        if ($type == self::USER_TYPE_FIRST) {
            $userType = self::USER_TYPE_FIRST;
        } else if ($type == self::USER_TYPE_SECOND) {
            $userType = self::USER_TYPE_SECOND;
        } else if ($type == self::USER_TYPE_THREE) {
            $userType = self::USER_TYPE_THREE;
        }
        return $userType;
    }
}
