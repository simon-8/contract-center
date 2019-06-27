<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contract;
use App\Models\ContractTplFill;
use App\Models\ContractTplRule;
use App\Services\ModelService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContractController extends Controller
{

    /**
     * 列表
     * @param \Request $request
     * @param Contract $contract
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(\Request $request, Contract $contract)
    {
        $data = $request::only([
            'catid',
            'userid',
            'targetid',
            'jiafang',
            'yifang',
            'status',
            'created_at',
            'type',
            'keyword'
        ]);
        $lists = $contract->ofCatid($data['catid'] ?? '')
            ->ofUserid($data['userid'] ?? 0)
            ->ofTargetid($data['targetid'] ?? 0)
            ->ofJiafang($data['jiafang'] ?? '')
            ->ofYifang($data['yifang'] ?? '')
            ->ofStatus($data['status'] ?? '')
            ->ofCreatedAt($data['created_at'] ?? '');

        if (!empty($data['type']) && !empty($data['keyword'])) {
            $func = "of{$data['type']}";
            $lists->whereHas('user', function($query) use ($func, $data) {
                $query->$func($data['keyword']);
            });
        }
        $lists = $lists->paginate(ModelService::$pagesize);
        $lists->appends($data);
        return view('admin.contract.index', compact('lists', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * 详情
     * @param Contract $contract
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Contract $contract)
    {
        $fills = ContractTplFill::ofCatid([0, $contract->catid])->get();
        $rules = ContractTplRule::ofCatid([0, $contract->catid])->get();
        return view('admin.contract.show', compact('contract', 'fills', 'rules'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除
     * @param Contract $contract
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Contract $contract)
    {
        if (!$contract->delete()) {
            return back()->withErrors('删除失败')->withInput();
        }
        return redirect()->route('admin.contract.index')->with('message' , __('web.success'));
    }
}
