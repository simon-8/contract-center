<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/8/13
 */
namespace App\Http\Controllers\Admin;

use App\Models\ExpressFee;

class ExpressFeeController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $lists = ExpressFee::all();
        return view('admin.express_fee.index', compact('lists'));
    }

    /**
     * 保存价格
     * @param \Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(\Request $request)
    {
        $fees = $request::input('fee');
        foreach ($fees as $areaid => $fee) {
            ExpressFee::ofId($areaid)->update(['amount' => $fee]);
        }

        return redirect()->route('admin.express-fee.index')->with('message', __('web.success'));
    }
}
