<?php
/**
 * Note: 企业打款通知
 * User: Liu
 * Date: 2019/7/13
 * Time: 22:54
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\UserCompany;
use App\Models\UserCompanyOrder;
use EasyWeChat\Factory;

class UserCompanyOrderController extends Controller
{

    /**
     * 转发通知
     * @param \Request $request
     * @param $pid
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function notify(\Request $request, $pid)
    {
        logger(__METHOD__, $request::all());
        $notifyData = $request::input('esign_return');
        $notifyData = json_decode($notifyData, true);
        if ($notifyData['result'] !== 'PAY_SUCCESS') {
            return responseException(__('api.failed'));
        }
        //$order = UserCompanyOrder::where('pid', $pid)->first();
        //if ($notifyData['msg']) $order->remark = $notifyData['msg'];
        //$order->save();
        $userCompany = UserCompany::find($pid);
        $userCompany->status = UserCompany::STATUS_PAYED;
        $userCompany->save();

        //$userCompany->user->update(['vcompany' => 1]);
        return '';
    }

    /**
     * 支付成功
     * @param Order $order
     */
    protected function paySuccess(Order $order)
    {
        // 付款成功事件
        //event(new \App\Events\OrderPayed($order));
    }
}
