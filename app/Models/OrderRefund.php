<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderRefund
 *
 * @property-read \App\Models\Order $order
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderRefund newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderRefund newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderRefund query()
 * @mixin \Eloquent
 */
class OrderRefund extends Model
{
    const STATUS_WAIT_CONFIRM = 0;// 已提交申请 待微信通过
    const STATUS_REFUND_SUCCESS = 1;// 退款成功
    const STATUS_REFUND_FAIL = 2;// 退款拒绝 需查看remark

    protected $table = 'order_refund';

    protected $fillable = [
        'pid',
        'refund_orderid',
        'refund_torderid',
        'pay_orderid',
        'amount',
        'userid',
        'adminid',
        'remark',
        'status',
    ];

    /**
     * 关联订单
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'pid', 'id');
    }

    /**
     * 用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'userid', 'id');
    }

    public function getStatus() {
        $statusArr = [
            self::STATUS_WAIT_CONFIRM => '退款审核中',
            self::STATUS_REFUND_SUCCESS => '已退款',
            self::STATUS_REFUND_FAIL => '退款失败',
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

}
