<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class Contract extends Base
{
    use ModelTrait;

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

        'companyid_first',
        'companyid_second',
        'companyid_three',

        'confirm_first',
        'confirm_second',
        'confirm_three',

        'signed_first',
        'signed_second',
        'signed_three',

        'sign_type_first',
        'sign_type_second',
        'sign_type_three',

        'status',
        'path_pdf',
        'confirm_at',
    ];

    const STATUS_APPLY = 0;
    const STATUS_CONFIRM = 1;
    const STATUS_PAYED = 2;
    const STATUS_SIGN = 3;
    const STATUS_LAWYER_CONFIRM = 4;

    // 用户类型 first甲 second乙 three居间
    const USER_TYPE_FIRST = 'first';
    const USER_TYPE_SECOND = 'second';
    const USER_TYPE_THREE = 'three';

    // 分类
    const CAT_NORMAL = 0;
    const CAT_DOUBLE = 1;
    const CAT_THREE = 2;

    // 签名类型 0个人 1公司
    const SIGN_TYPE_PERSON = 0;
    const SIGN_TYPE_COMPANY = 1;

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
     * 关联创建人
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'userid', 'id');
    }

    /**
     * 关联甲方
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userFirst()
    {
        return $this->belongsTo('App\Models\User', 'userid_first', 'id');
    }

    /**
     * 关联乙方
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userSecond()
    {
        return $this->belongsTo('App\Models\User', 'userid_second', 'id');
    }

    /**
     * 关联居间人
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userThree()
    {
        return $this->belongsTo('App\Models\User', 'userid_three', 'id');
    }

    /**
     * 关联甲方公司
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function companyFirst()
    {
        return $this->belongsTo('App\Models\UserCompany', 'companyid_first', 'id');
    }

    /**
     * 关联乙方公司
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function companySecond()
    {
        return $this->belongsTo('App\Models\UserCompany', 'companyid_second', 'id');
    }

    /**
     * 关联居间公司
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function companyThree()
    {
        return $this->belongsTo('App\Models\UserCompany', 'companyid_three', 'id');
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
     * 我的(我创建的 我参与的)
     * @param $query
     * @param int $data
     * @return mixed
     */
    public function scopeOfMine($query, $data = 0)
    {
        if (!$data) return $query;
        return $query->where('userid', $data)->orWhere('userid_first', $data)->orWhere('userid_second', $data)->orWhere('userid_three', $data);
    }

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
            self::STATUS_APPLY => '一方申请',
            self::STATUS_CONFIRM => '双方确认',
            self::STATUS_PAYED => '一方支付',
            self::STATUS_SIGN => '双方签名',
            self::STATUS_LAWYER_CONFIRM => '已见证',
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
