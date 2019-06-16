<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'contract';

    protected $fillable = [
        'name',
        'userid',
        'lawyerid',
        'mycatid',
        'jiafang',
        'yifang',
        'jujianren',
        'status',
        'confirm_at',
    ];

    const STATUS_APPLY = 0;
    const STATUS_CONFIRM = 1;
    const STATUS_SIGN = 2;

    /**
     * 关联内容
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function content()
    {
        return $this->hasOne('App\Models\ContractContent', 'id', 'id');
    }

    /**
     * 状态
     * @param $query
     * @param null $data
     * @return mixed
     */
    public function scopeOfStatus($query, $data = '')
    {
        if ($data === '') return $query;
        if (is_array($data)) {
            return $query->whereIn('status', $data);
        } else {
            return $query->where('status', $data);
        }
    }

    /**
     * 用户id
     * @param $query
     * @param int $data
     * @return mixed
     */
    public function scopeOfUserid($query, $data = 0)
    {
        if (!$data) return $query;
        return $query->where('userid', $data);
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
     * 获取状态数组
     * @param null $status
     * @return array
     */
    public function getStatus()
    {
        $statusArr = [
            self::STATUS_APPLY => '已申请',
            self::STATUS_CONFIRM => '已确认',
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
