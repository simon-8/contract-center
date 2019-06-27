<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/6/26
 * Time: 0:00
 */
namespace App\Http\Controllers\Api;

use App\Http\Requests\OrderRequest;
use App\Models\Contract;
use App\Models\Order;
use App\Models\OrderRefund;
use App\Models\User;
use EasyWeChat\Factory;
use function EasyWeChat\Kernel\Support\generate_sign;

class OrderController extends BaseController
{
    /**
     * 下单
     * @param OrderRequest $request
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(OrderRequest $request, Order $order)
    {
        logger('order.store', $request->all());
        $data = $request::only([
            'contract_id',
            'channel',
            'gateway',
        ]);
        $request->validateStore($data);

        $gateway = $data['gateway'] ?? '';
        $channel = $data['channel'] ?? '';

        //if (empty($gateway)) {
        //    return responseException('支付方式缺失');
        //}
        if (empty($channel) || !method_exists($this, $channel)) {
            return responseException('支付通道不存在, 请检查channel值');
        }

        $contract = Contract::find($data['contract_id']);
        if ($contract->status >= Contract::STATUS_PAYED) {
            return responseException('该合同已支付, 无法重复付款');
        }
        $data['userid'] = $this->user->id;
        $data['amount'] = 1;
        $data['openid'] = $this->getOpenid();
        $data['orderid'] = Order::createOrderNo($channel);
        $orderData = $order->create($data);
        if (!$orderData) {
            return responseException('订单创建失败, 请稍候重试');
        }
        return $this->$channel($orderData, $gateway);
    }

    /**
     * 获取用户openid
     * @return string
     */
    public function getOpenid()
    {
        $openid = '';
        if ($this->client_id === User::CLIENT_ID_MINI_PROGRAM) {
            $openid = $this->user->miniGameOpenid();
        } else if ($this->client_id === User::CLIENT_ID_WECHAT) {
            $openid = $this->user->wechatOpenid();
        }
        return $openid;
    }

    /**
     * 重新付款
     * @param Order $order
     * @param $orderid
     * @return \Illuminate\Http\JsonResponse
     */
    public function reStore(Order $order, $orderid)
    {
        $orderData = $order->where('orderid', $orderid)->first();
        if (!$orderData) {
            return responseException(__('api.no_result'));
        }
        if ($orderData->status != Order::STATUS_WAIT_PAY) {
            return responseException('该订单'.$orderData->getStatusText(). ', 无法继续付款');
        }
        if ($orderData->contract->status >= Contract::STATUS_PAYED) {
            return responseException('该合同'.$orderData->contract->getStatusText(). ', 无法继续付款');
        }
        $channel = $orderData->channel;
        $gateway = $orderData->gateway;
        return $this->$channel($orderData, $gateway);
    }

    /**
     * 微信预下单
     * @param Order $order
     * @param string $gateway
     * @return \Illuminate\Http\JsonResponse
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function wechat(Order $order, $gateway = '')
    {
        $config = [
            'sandbox' => true,
            'app_id' => config('wechat.payment.default.app_id'),
            'mch_id' => config('wechat.payment.default.mch_id'),
            'key'    => config('wechat.payment.default.key'),
        ];

        $app = Factory::payment($config);
        $data = [
            'body' => '用户充值',
            'out_trade_no' => $order->orderid,
            'total_fee' => $order->amount,
            'spbill_create_ip' => \Request::ip(),
            'notify_url' => route('api.order.notify', ['channel' => __FUNCTION__]),
            'trade_type' => $gateway ?: 'JSAPI',
            'openid' => $order->openid,
        ];
        $response = $app->order->unify($data);
        logger('wechat prepay param', $data);
        logger('wechat prepay response', $response);
        if ($response['return_code'] === 'FAIL') {
            return responseException($response['return_msg']);
        }
        // 二次签名
        $params = [
            'appId'     => $config['app_id'],
            'timeStamp' => (string) time(),
            'nonceStr'  => $response['nonce_str'],
            'package'   => 'prepay_id=' . $response['prepay_id'],
            'signType'  => 'MD5',
        ];

        $params['paySign'] = generate_sign($params, $config['key']);

        return responseMessage('', $params);
    }

    /**
     * 转发通知
     * @param $channel
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \EasyWeChat\Kernel\Exceptions\Exception
     */
    public function notify($channel)
    {
        if ($channel === 'wechat') {
            return $this->notifyWechat();
        }
    }

    /**
     * 微信回调通知
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \EasyWeChat\Kernel\Exceptions\Exception
     */
    protected function notifyWechat()
    {
        $config = [
            'app_id' => config('wechat.payment.default.app_id'),
            'mch_id' => config('wechat.payment.default.mch_id'),
            'key'    => config('wechat.payment.default.key'),
        ];
        \Log::debug('notify => '. file_get_contents('php://input'));

        $app = Factory::payment($config);
        $response = $app->handlePaidNotify(function($message, $fail){
            logger('notifyWechat data ==> ', $message);

            if ($message['return_code'] !== 'SUCCESS') {
                return $fail('通信失败，请稍后再通知我');
            }
            if ($message['result_code'] !== 'SUCCESS') {
                \Log::info('notifyWechat result ==> 订单状态未成功, 结束订单');
                return true;
            }
            $order = Order::where('orderid', $message['out_trade_no'])->first();
            \Log::info('notifyWechat order ==> '. var_export($order->toArray(), true));
            if (!$order) {
                \Log::info('notifyWechat result ==> 订单不存在');
                return true;
            }
            if ($order->status != Order::STATUS_WAIT_PAY) {
                \Log::info('notifyWechat result ==> 订单已付款或已取消');
                return true;
            }
            if (!$this->wechatQuery($order->orderid)) {
                \Log::info('notifyWechat result ==> 订单状态校验失败');
                return $fail('订单状态校验失败');
            }

            if ($message['total_fee'] != $order['money']*100) {
                \Log::info('notifyWechat result ==> 订单金额不匹配');
                return $fail('订单金额不匹配');
            }
            $order->status = Order::STATUS_ALREADY_PAY;
            $order->torderid = $message['transaction_id'];
            $order->payed_at = date('Y-m-d H:i:s');
            $order->save();

            // 更新关联状态
            $order->contract->update([
                'status' => Contract::STATUS_PAYED
            ]);
            // todo 支付成功
            //event(new \App\Events\OrderPayed($order));
            return true;
        });

        return $response;
    }

    /**
     * 微信订单查询 (根据商户订单号)
     * @param $out_trade_no
     * @return bool
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    protected function wechatQuery($out_trade_no)
    {
        $config = [
            'app_id' => config('wechat.payment.default.app_id'),
            'mch_id' => config('wechat.payment.default.mch_id'),
            'key'    => config('wechat.payment.default.key'),
        ];

        $app = Factory::payment($config);
        $response = $app->order->queryByOutTradeNumber($out_trade_no);

        logger('wechatQueryOrder RESPONSE ==> ', $response);

        if ($response['return_code'] !== 'SUCCESS') {
            return false;
        }
        if ($response['result_code'] !== 'SUCCESS') {
            return false;
        }

        if (!isset($response['trade_state']) || $response['trade_state'] !== 'SUCCESS') {
            return false;
        }
        return true;
    }

    /**
     * 取消订单
     * 未付款直接取消
     * 已付款修改状态为申请退款 自动退款或等待后台客服审核
     * @param \Request $request
     * @param OrderRefund $orderRefund
     * @param $orderid
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel(\Request $request, OrderRefund $orderRefund, $orderid)
    {
        $user = $request::user();
        $orderData = Order::where('orderid', $orderid)->first();
        if (!$orderData) {
            return responseException(__('api.no_result'));
        }
        if ($orderData->status > Order::STATUS_CONFIRM) {
            return responseException('该订单当前状态: '.$orderData->getStatusText(). ', 无法继续退款');
        }

        if ($orderData->status == Order::STATUS_WAIT_PAY) {
            $orderData->status = Order::STATUS_TRADE_CLOSE;
            $orderData->save();

            // 订单已处理通知
            //OrderGateway::orderProcessed($order);

            return responseMessage(__('api.success'));
        }

        if ($orderData->status == Order::STATUS_ALREADY_PAY || $orderData->status == Order::STATUS_CONFIRM) {
            // todo 是否自动退款
            if (true) {
                $refundOrderid = Order::createOrderNo($orderData->channel);
                $totalFee = $refundFee = $orderData->money*100;

                $app = Factory::payment(config('wechat.payment.default'));
                try {
                    $response = $app->refund->byTransactionId($orderData->torderid, $refundOrderid, $totalFee, $refundFee, [
                        'refund_desc' => '用户申请退款',
                        'notify_url' => route('api.order.refund', ['channel' => $orderData->channel]),
                    ]);
                    logger('refund response', $response);
                } catch (\Exception $e) {
                    return responseException($e->getMessage());
                }

                if ($response['return_code'] !== 'SUCCESS') {
                    return responseException($response['return_msg']);
                }
                if ($response['result_code'] !== 'SUCCESS') {
                    return responseException($response['err_code_des']);
                }
                // 订单退款记录
                $orderRefund->create([
                    'pid' => $orderData->id,
                    'refund_orderid' => $refundOrderid,
                    'refund_torderid' => $response['refund_id'],
                    'pay_orderid' => $orderData->orderid,
                    'amount' => $totalFee/100,
                    'userid' => $user->id,
                    //'adminid' => 0,
                    //'remark' => '',
                    //'status' => 0,
                ]);
                $message = '退款申请提交成功';

                // todo 通知
                //event(new \App\Events\OrderCancel($order));

            } else {
                $message = '退款申请提交成功, 等待客服审核';
            }
            $orderData->status = Order::STATUS_APPLY_REFUND;
            $orderData->save();

            return responseMessage($message);
        }
    }


    /**
     * 退款
     * @param $channel
     * @throws \EasyWeChat\Kernel\Exceptions\Exception
     */
    public function refund($channel)
    {
        $method = 'refund'.ucfirst($channel);
        return $this->$method();
    }

    /**
     * 退款
     * @throws \EasyWeChat\Kernel\Exceptions\Exception
     */
    public function refundWechat()
    {
        $config = [
            'app_id' => config('wechat.payment.default.app_id'),
            'mch_id' => config('wechat.payment.default.mch_id'),
            'key'    => config('wechat.payment.default.key'),
        ];

        $app = Factory::payment($config);
        $response = $app->handleRefundedNotify(function ($message, $reqInfo, $fail) {
            logger('refund notify', $message);
            logger('refund notify', $reqInfo);
            if ($message['return_code'] !== 'SUCCESS') {
                return $fail('通信失败，请稍后再通知我');
            }
            $refundData = OrderRefund::where('refund_orderid', $reqInfo['out_refund_no'])->first();
            if (!$refundData) {
                \Log::info('refund notify ==> 订单不存在');
                return true;
            }
            if ($refundData->status == OrderRefund::STATUS_REFUND_SUCCESS) {
                \Log::info('refund notify ==> 订单状态已成功, 结束订单');
                return true;
            }
            $orderData = Order::find($refundData->pid);

            $refundData->refund_torderid = $reqInfo['refund_id'];
            if ($reqInfo['refund_status'] !== 'SUCCESS') {
                $statusArr = [
                    'CHANGE' => '退款异常',
                    'REFUNDCLOSE' => '退款关闭'
                ];

                $refundData->status = OrderRefund::STATUS_REFUND_FAIL;
                $refundData->remark = $statusArr[$reqInfo['refund_status']];
                $refundData->save();

                $orderData->status = Order::STATUS_REFUND_FAILD;
                $orderData->save();
                \Log::info('notifyWechat result ==> 订单状态未成功, 结束订单');
                return true;
            }
            $refundData->status = OrderRefund::STATUS_REFUND_SUCCESS;
            $refundData->save();

            $orderData->status = Order::STATUS_REFUND_SUCCESS;
            $orderData->save();

            // 修改合同状态为已确认
            $orderData->contract->update([
                'status' => Contract::STATUS_CONFIRM
            ]);
            return true;
        });

        $response->send();
    }
}