<?php
/**
 * Note: 订单
 * User: Liu
 * Date: 2019/11/14
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderLawyerConfirm
 *
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
 * @property array|mixed $address 地址json
 * @property int $status 状态 0待支付 1已支付
 * @property int $client_id 客户端ID
 * @property string|null $payed_at 付款时间
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Contract $contract
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLawyerConfirm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLawyerConfirm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofCatid($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLawyerConfirm ofContractID($data = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofCreatedAt($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofStatus($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofUserid($data = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLawyerConfirm query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLawyerConfirm whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLawyerConfirm whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLawyerConfirm whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLawyerConfirm whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLawyerConfirm whereContractId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLawyerConfirm whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLawyerConfirm whereGateway($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLawyerConfirm whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLawyerConfirm whereOpenid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLawyerConfirm whereOrderid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLawyerConfirm wherePayedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLawyerConfirm whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLawyerConfirm whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLawyerConfirm whereTorderid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLawyerConfirm whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLawyerConfirm whereUserid($value)
 * @mixin \Eloquent
 */
class OrderLawyerConfirm extends Base
{
    const STATUS_WAIT_PAY = 0;// 待付款
    const STATUS_ALREADY_PAY = 1;// 已付款

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
            self::STATUS_WAIT_PAY => '待支付',
            self::STATUS_ALREADY_PAY => '已支付',
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