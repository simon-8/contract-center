<?php
/**
 * Note: 订单
 * User: Liu
 * Date: 2019/11/14
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order query()
 * @mixin \Eloquent
 * @property-read \App\Models\Contract $contract
 * @property-read \App\Models\User $user
 * @property int $id
 * @property int $contract_id 合同ID
 * @property int $userid 用户ID
 * @property float $amount 金额
 * @property string $orderid 订单ID
 * @property string $torderid 第三方订单ID
 * @property string $channel 支付渠道
 * @property string $gateway 支付方式
 * @property string $openid openid
 * @property string $remark 备注
 * @property int $status 状态 0待支付 1已支付 2申请退款 3退款失败 4已退款 9已关闭
 * @property int $client_id 客户端ID
 * @property string|null $payed_at 付款时间
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereContractId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereGateway($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereOpenid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereOrderid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePayedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereTorderid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUserid($value)
 */
class Order extends Model
{
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