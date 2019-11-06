<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Services\ModelService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{

    /**
     * 列表
     * @param \Request $request
     * @param Company $company
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(\Request $request, Company $company)
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
        //$lists = $contract->ofCatid($data['catid'] ?? '')
        //    ->ofUserid($data['userid'] ?? 0)
        //    //->ofTargetid($data['targetid'] ?? 0)
        //    ->ofJiafang($data['jiafang'] ?? '')
        //    ->ofYifang($data['yifang'] ?? '')
        //    ->ofStatus($data['status'] ?? '')
        //    ->ofCreatedAt($data['created_at'] ?? '');
        //
        //if (!empty($data['type']) && !empty($data['keyword'])) {
        //    $func = "of{$data['type']}";
        //    $lists->whereHas('user', function($query) use ($func, $data) {
        //        $query->$func($data['keyword']);
        //    });
        //}
        $lists = Company::orderByDesc('id')->paginate();
        $lists->appends($data);
        return view('admin.company.index', compact('lists', 'data'));
    }

    /**
     * 详情
     * @param Company $company
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Company $company)
    {
        //$sections = json_decode($contract->content->tpl, true);
        //$fill = json_decode($contract->content->fill, true);
        //return view('api.contract.show', compact('contract', 'sections', 'fill'));
    }

    /**
     * 删除
     * @param Company $company
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Company $company)
    {
        if (!$company->delete()) {
            return back()->withErrors('删除失败')->withInput();
        }
        return redirect()->route('admin.company.index')->with('message' , __('web.success'));
    }
}
