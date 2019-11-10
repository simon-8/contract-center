<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/8/11
 * Time: 10:40
 */
namespace App\Http\Controllers\Admin;

use App\Http\Requests\ContractCategoryRequest;
use App\Models\Contract;
use App\Models\ContractCategory;
use App\Models\ContractTplSection;

class ContractCategoryController extends BaseController
{
    /**
     * 合同类型
     * @param \Request $request
     * @param ContractCategory $contractCategory
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(\Request $request, ContractCategory $contractCategory)
    {
        $data = $request::only(['company_id']);
        $lists = $contractCategory->ofCompanyId($data['company_id'] ?? 0)
            ->with(['tplSection' => function($query) {
                $query->orderByDesc('listorder');
            }]);
        $players = Contract::getPlayers();

        if (empty($data['company_id'])) {
            $lists = $lists->paginate();
            $template = 'admin.contract_category.index';
        } else {
            $tmp = $lists->get()->toArray();
            $lists = [];
            foreach ($tmp as $k => $v) {
                if (!$v['pid']) {
                    $lists[$v['id']] = $v;
                }
            }

            foreach ($tmp as $k => $v) {
                if ($v['pid']) {
                    $lists[$v['pid']]['child'][$v['id']] = $v;
                }
            }
            $lists = collect($lists);
            $template = 'admin.contract_category.company';
        }
        return view($template, compact('lists', 'players', 'data'));
    }

    /**
     * @param ContractTplSection $contractTplSection
     * @param ContractCategory $contractCategory
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(ContractTplSection $contractTplSection, ContractCategory $contractCategory)
    {
        $data = [];
        $data['players'] = Contract::getPlayers();
        $data['catid'] = $contractCategory->id;
        foreach ($data['players'] as $typeid => $typename) {
            $data['tplSection'][$typeid] = $contractTplSection->ofCatid($contractCategory->id)
                ->ofPlayers($typeid)
                ->orderByDesc('listorder')
                ->get();
        }
        return view('admin.contract_category.show', compact('contractCategory', 'data'));
    }

    /**
     * 添加
     * @param ContractCategoryRequest $request
     * @param ContractCategory $contractCategory
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(ContractCategoryRequest $request, ContractCategory $contractCategory)
    {
        $data = $request->all();
        $request->validateStore($data);

        if (!$contractCategory->create($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('admin.contract-category.index', [
            'company_id' => $data['company_id'] ?? 0
        ])->with('message' , __('web.success'));
    }

    /**
     * 更新
     * @param ContractCategoryRequest $request
     * @param ContractCategory $contractCategory
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(ContractCategoryRequest $request, ContractCategory $contractCategory)
    {
        $data = $request->all();
        $request->validateUpdate($data);

        if (!$contractCategory->update($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }
        return redirect()->route('admin.contract-category.index', [
            'company_id' => $data['company_id'] ?? 0
        ])->with('message' , __('web.success'));
    }

    /**
     * 删除
     * @param ContractCategory $contractCategory
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(ContractCategory $contractCategory)
    {
        if (!$contractCategory->delete()) {
            return back()->withErrors('删除失败')->withInput();
        }
        return redirect()->route('admin.contract-category.index', [
            'company_id' => $contractCategory->company_id
        ])->with('message' , __('web.success'));
    }
}
