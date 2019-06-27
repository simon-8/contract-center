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
 * @property int $user_confirm
 * @property int $target_confirm
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
 */
class Contract extends Base
{
    protected $table = 'contract';

    protected $fillable = [
        'name',
        'catid',
        'userid',
        'targetid',
        'lawyerid',
        'mycatid',
        'jiafang',
        'yifang',
        'jujianren',
        'user_confirm',
        'target_confirm',
        'status',
        'confirm_at',
    ];

    const STATUS_APPLY = 0;
    const STATUS_CONFIRM = 1;
    const STATUS_PAYED = 2;
    const STATUS_SIGN = 3;

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
    public function target()
    {
        return $this->belongsTo('App\Models\User', 'targetid', 'id');
    }

    /**
     * 对方用户ID
     * @param $query
     * @param int $data
     * @return mixed
     */
    public function scopeOfTargetid($query, $data = 0)
    {
        if (!$data) return $query;
        return $query->where('targetid', $data);
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
            0 => '通用',
            1 => '两方',
            2 => '三方',
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
}
