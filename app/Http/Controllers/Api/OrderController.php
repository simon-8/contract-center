<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/6/26
 * Time: 0:00
 */
namespace App\Http\Controllers\Api;

use EasyWeChat\Factory;
use function EasyWeChat\Kernel\Support\generate_sign;

class OrderController extends BaseController
{
    public function wechat($order = [], $gateway = '')
    {
        $config = [
            'app_id' => config('wechat.payment.default.app_id'),
            'mch_id' => config('wechat.payment.default.mch_id'),
            'key'    => config('wechat.payment.default.key'),
        ];

        $app = Factory::payment($config);
        $data = [
            'body' => '充值中心-会员充值',
            'out_trade_no' => $order->orderid,
            'total_fee' => $order->money * 100,
            'spbill_create_ip' => \Request::ip(),
            'notify_url' => route('api.order.notify', ['channel' => __FUNCTION__]),
            'trade_type' => $gateway,
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
}