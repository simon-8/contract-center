<?php
/**
 * Note: 订单
 * User: Liu
 * Date: 2019/11/14
 */
namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OrderLawyerConfirm extends Base
{
    use ModelTrait;

    const STATUS_APPLY = 0;// 已申请
    const STATUS_HAS_BEEN_SEND = 1;// 已发送

    public $table = 'order_lawyer_confirm';

    //public $timestamps = false;

    public $fillable = [
        'contract_id',
        'userid',
        'amount',
        'orderid',
        'torderid',
        'channel',
        'gateway',
        'openid',
        'remark',
        'address',
        'express_name',
        'express_no',
        'status',
        'client_id',
        'payed_at',
    ];

    /**
     * @param $value
     * @return array|mixed
     */
    public function getAddressAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    /**
     * @param $value
     */
    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = $value ? json_encode($value) : '';
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
     * 关联合同
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contract()
    {
        return $this->belongsTo('App\Models\Contract', 'contract_id', 'id');
    }

    /**
     * @param Builder $query
     * @param string $data
     * @return Builder
     */
    public function scopeOfOrderid(Builder $query, $data = '')
    {
        if (!$data) return $query;
        return $query->where('orderid', $data);
    }

    /**
     * 合同ID
     * @param $query
     * @param int $data
     * @return mixed
     */
    public function scopeOfContractID($query, $data = 0)
    {
        if (empty($data)) return $query;
        return $query->where('contract_id', $data);
    }

    /**
     * 所有状态
     * @return array
     */
    public function getStatus() {
        $statusArr = [
            self::STATUS_APPLY => '已申请',
            self::STATUS_HAS_BEEN_SEND => '已发送',
        ];
        return $statusArr;
    }

    /**
     * 获取状态文字
     * @param null $status
     * @return mixed
     */
    public function getStatusText($status = null)
    {
        if (!isset($status)) $status = $this->status;
        return $this->getStatus()[$status];
    }

    /**
     * 生成订单号
     * @param $channel
     * @return string
     */
    public static function createOrderNo($channel = '')
    {
        switch ($channel) {
            case 'wechat':
                $prefix = 'WX';
                break;
            case 'alipay':
                $prefix = 'ALI';
                break;
            default:
                $prefix = 'NO';
                break;
        }
        return $prefix . date('YmdHis').mt_rand(1000, 9999);
    }
}
