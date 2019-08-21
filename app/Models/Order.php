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

class Order extends Model
{
    use ModelTrait;

    const STATUS_WAIT_PAY = 0;// 待付款
    const STATUS_ALREADY_PAY = 1;// 已付款
    const STATUS_CONFIRM = 2;// 已确认
    const STATUS_APPLY_REFUND = 3;// 申请退款
    const STATUS_REFUND_FAILD = 4;// 退款失败
    const STATUS_REFUND_SUCCESS = 5;// 退款成功
    const STATUS_TRADE_SUCCESS = 6;// 交易成功
    const STATUS_TRADE_CLOSE = 8;// 交易关闭
    const STATUS_TRADE_SELL_CLOSE = 9;// SELL交易关闭

    public $table = 'orders';

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
        'status',
        'client_id',
        'payed_at',
    ];

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
     * 所有状态
     * @return array
     */
    public function getStatus() {
        $statusArr = [
            self::STATUS_WAIT_PAY => '待支付',
            self::STATUS_ALREADY_PAY => '已支付',
            self::STATUS_CONFIRM => '已确认',
            self::STATUS_APPLY_REFUND => '申请退款',
            self::STATUS_REFUND_FAILD => '退款失败',
            self::STATUS_REFUND_SUCCESS => '退款成功',
            self::STATUS_TRADE_SUCCESS => '交易成功',
            self::STATUS_TRADE_CLOSE => '交易关闭',
            self::STATUS_TRADE_SELL_CLOSE => '卖家关闭',
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
