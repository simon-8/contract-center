<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/8/21
 */
namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\OrderLawyerConfirm;

class OperationController extends BaseController
{
    public function order(\Request $request, Order $order)
    {
        $data = $request::only(['updated_at', 'status', 'type', 'keyword', 'catid', 'players']);
        $lists = $order->ofUpdatedAt($data['updated_at'] ?? '')
            ->ofStatus($data['status'] ?? '')
            ->ofOrderid((!empty($data['type']) && $data['type'] === 'orderid') ? $data['keyword'] : '')
            ->whereHas('contract', function($query) use ($data) {
                if (!empty($data['catid'])) $query->ofCatid($data['catid']);
                if (!empty($data['players'])) $query->ofPlayers($data['players']);
                if (!empty($data['type']) && $data['type'] === 'name') $query->ofName($data['keyword']);
            })
            ->with('contract', 'user')
            ->orderByDesc('id')
            ->paginate();
        $lists->appends($data);
        return view('admin.operation.order', compact('lists', 'data'));
    }

    /**
     * @param \Request $request
     * @param OrderLawyerConfirm $orderLawyerConfirm
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    //public function orderLawyerConfirm(\Request $request, OrderLawyerConfirm $orderLawyerConfirm)
    //{
    //    $data = $request::only(['updated_at', 'status', 'type', 'keyword', 'catid', 'players']);
    //    $lists = $orderLawyerConfirm->ofUpdatedAt($data['updated_at'] ?? '')
    //        ->ofStatus($data['status'] ?? '')
    //        ->ofOrderid((!empty($data['type']) && $data['type'] === 'orderid') ? $data['keyword'] : '')
    //        ->whereHas('contract', function($query) use ($data) {
    //            if (!empty($data['catid'])) $query->ofCatid($data['catid']);
    //            if (!empty($data['players'])) $query->ofPlayers($data['players']);
    //            if (!empty($data['type']) && $data['type'] === 'name') $query->ofName($data['keyword']);
    //        })
    //        ->with('contract', 'user')
    //        ->orderByDesc('id')
    //        ->paginate();
    //    $lists->appends($data);
    //    return view('admin.operation.orderlawyerconfirm', compact('lists', 'data'));
    //}
}
