<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/6/26
 * Time: 0:00
 */
namespace App\Http\Controllers\Api;

use App\Http\Requests\OrderLawyerConfirmRequest as OrderRequest;
use App\Http\Resources\OrderLawyerConfirm as OrderLawyerConfirmResource;
use App\Models\Contract;
use App\Models\ExpressFee;
use App\Models\OrderLawyerConfirm as Order;
use App\Models\OrderRefund;
use App\Models\User;
use App\Models\UserAddress;
use EasyWeChat\Factory;
use function EasyWeChat\Kernel\Support\generate_sign;

class OrderLawyerConfirmController extends BaseController
{
    /**
     * 详情
     * @param \Request $request
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(\Request $request, Order $order)
    {
        $data = $request::only(['contract_id']);
        $orderData = $order->ofContractID($data['contract_id'])
            ->ofUserid($this->user->id)
            ->first();
        if ($orderData) {
            return responseMessage('', new OrderLawyerConfirmResource($orderData));
        }
        return responseMessage();
    }

    /**
     * 下单
     * @param OrderRequest $request
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(OrderRequest $request, Order $order)
    {
        logger('order.store', $request->all());
        $data = $request->only([
            'contract_id',
            'address_id',
        ]);
        $request->validateStore($data);

        // 已有order状态检查
        $orderData = $order->ofContractID($data['contract_id'])
            ->ofUserid($this->user->id)
            ->first();

        // 对应contract状态检查
        $contract = Contract::find($data['contract_id']);
        if ($contract->status < Contract::STATUS_SIGN) {
            return responseException('该合同尚未签名, 无法见证');
        }
        // 用户地址检查
        $address = UserAddress::find($data['address_id']);
        if (!$address) {
            return responseException('收货地址不存在, 请稍候重试');
        }

        $data['address'] = $address->only(['linkman', 'mobile', 'province', 'city', 'area', 'address']);
        $data['userid'] = $this->user->id;
        $data['amount'] = 0;
        $data['openid'] = $this->getOpenid();
        $data['orderid'] = '';

        // 有则更新 无则创建
        if ($orderData) {
            $orderData->update($data);
        } else {
            $orderData = $order->create($data);
        }

        if (!$orderData) {
            return responseException('申请失败, 请稍候重试');
        }
        return responseMessage();
    }


    /**
     * 重新付款
     * @param Order $order
     * @param $orderid
     * @return \Illuminate\Http\JsonResponse
     */
    //public function reStore(Order $order, $orderid)
    //{
    //    $orderData = $order->where('orderid', $orderid)->first();
    //    if (!$orderData) {
    //        return responseException(__('api.no_result'));
    //    }
    //    if ($orderData->status != Order::STATUS_WAIT_PAY) {
    //        return responseException('该订单'.$orderData->getStatusText(). ', 无法继续付款');
    //    }
    //    if ($orderData->contract->status >= Contract::STATUS_PAYED) {
    //        return responseException('该合同'.$orderData->contract->getStatusText(). ', 无法继续付款');
    //    }
    //    $channel = $orderData->channel;
    //    $gateway = $orderData->gateway;
    //    return $this->$channel($orderData, $gateway);
    //}

    /**
     * 微信预下单
     * @param Order $order
     * @param string $gateway
     * @return \Illuminate\Http\JsonResponse
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    /*public function wechat(Order $order, $gateway = '')
    {
        $config = [
            //'sandbox' => true,
            'app_id' => config('wechat.payment.default.app_id'),
            'mch_id' => config('wechat.payment.default.mch_id'),
            'key'    => config('wechat.payment.default.key'),
        ];

        $app = Factory::payment($config);
        $data = [
            'body' => '申请律师见证',
            'out_trade_no' => $order->orderid,
            'total_fee' => $order->amount * 100,
            'spbill_create_ip' => \Request::ip(),
            'notify_url' => route('api.orderLawyerConfirm.notify', ['channel' => __FUNCTION__]),
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
    }*/

    /**
     * 转发通知
     * @param $channel
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \EasyWeChat\Kernel\Exceptions\Exception
     */
/*    public function notify($channel)
    {
        if ($channel === 'wechat') {
            return $this->notifyWechat();
        }
    }*/

    /**
     * 微信回调通知
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \EasyWeChat\Kernel\Exceptions\Exception
     */
    /*protected function notifyWechat()
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

            if ($message['total_fee'] != $order['amount']*100) {
                \Log::info('notifyWechat result ==> 订单金额不匹配');
                return $fail('订单金额不匹配');
            }
            $order->status = Order::STATUS_WAIT_SEND;
            $order->torderid = $message['transaction_id'];
            $order->payed_at = date('Y-m-d H:i:s');
            $order->save();

            // 更新关联状态
            //$order->contract->update([
            //    'status' => Contract::STATUS_LAWYER_CONFIRM
            //]);
            // todo 支付成功
            //event(new \App\Events\OrderPayed($order));
            return true;
        });

        return $response;
    }*/

    /**
     * 微信订单查询 (根据商户订单号)
     * @param $out_trade_no
     * @return bool
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    /*protected function wechatQuery($out_trade_no)
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
    }*/

    /**
     * 快递费用查询
     * @param \Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    /*public function queryExpressFee(\Request $request)
    {
        $fee = 0;
        try {
            $expressFee = ExpressFee::find($request::input('address_id'));
            if ($expressFee) {
                $fee = $expressFee->amount;
            }
        } catch (\Exception $exception) {

        }
        if (!$fee) {
            $fee = config('admin.contractLawyerConfirmPrice');
        }
        return responseMessage(__('api.success'), compact('fee'));
    }*/
}
