<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/8/22
 * Time: 1:35
 */
namespace App\Http\Controllers\Admin;

use App\Models\OrderLawyerConfirm;

class OrderLawyerConfirmController extends BaseController
{
    public function index(\Request $request, OrderLawyerConfirm $orderLawyerConfirm)
    {
        $data = $request::only(['updated_at', 'status', 'type', 'keyword', 'catid', 'players']);
        $lists = $orderLawyerConfirm->ofUpdatedAt($data['updated_at'] ?? '')
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
        return view('admin.order_lawyer_confirm.index', compact('lists', 'data'));
    }

    /**
     * 更新
     * @param \Request $request
     * @param OrderLawyerConfirm $orderLawyerConfirm
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(\Request $request, OrderLawyerConfirm $orderLawyerConfirm)
    {
        $data = $request::all();
        if (!$orderLawyerConfirm->update($data)) {
            return back()->withInput()->withErrors(__('web.failed'));
        }
        return redirect()->route('admin.order-lawyer-confirm.index')->with('message', __('web.success'));
    }

    /**
     * 发货
     * @param \Request $request
     * @param OrderLawyerConfirm $orderLawyerConfirm
     * @return \Illuminate\Http\RedirectResponse
     */
    public function send(\Request $request, OrderLawyerConfirm $orderLawyerConfirm)
    {
        $data = $request::all();
        $data['status'] = OrderLawyerConfirm::STATUS_HAS_BEEN_SEND;
        if (!$orderLawyerConfirm->update($data)) {
            return back()->withInput()->withErrors(__('web.failed'));
        }
        return redirect()->route('admin.order-lawyer-confirm.index')->with('message', __('web.success'));
    }
}
