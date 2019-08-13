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

    public function store()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
