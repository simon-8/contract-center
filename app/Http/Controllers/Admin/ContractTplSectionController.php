<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ContractTplSectionRequest;
use App\Models\ContractTplSection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContractTplSectionController extends Controller
{
    /**
     * @param \Request $request
     * @param ContractTplSection $contractTplSection
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(\Request $request, ContractTplSection $contractTplSection)
    {
        $data = $request::only(['created_at', 'content', 'catid']);
        $lists = $contractTplSection->ofCatid($data['catid'] ?? '')
            ->ofCreatedAt($data['created_at'] ?? '')
            ->ofName($data['content'] ?? '')
            ->orderByDesc('id')
            ->paginate();
        return view('admin.contract_tpl_section.index', compact('lists', 'data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.contract_tpl_section.create');
    }

    /**
     * @param ContractTplSectionRequest $request
     * @param ContractTplSection $contractTplSection
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(ContractTplSectionRequest $request, ContractTplSection $contractTplSection)
    {
        $data = $request->all();
        $request->validateStore($data);

        if (!$contractTplSection->create($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }

        return back()->with('message', __('web.success'));
    }

    /**
     * @param ContractTplSection $contractTplSection
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(ContractTplSection $contractTplSection)
    {
        return view('admin.contract_tpl_section.create', compact('contractTpl'));
    }

    /**
     * @param ContractTplSectionRequest $request
     * @param ContractTplSection $contractTplSection
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(ContractTplSectionRequest $request, ContractTplSection $contractTplSection)
    {
        $data = $request->all();
        $request->validateUpdate($data);

        if (!$contractTplSection->update($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }

        return back()->with('message', __('web.success'));
    }

    /**
     * @param ContractTplSection $contractTplSection
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(ContractTplSection $contractTplSection)
    {
        if ($contractTplSection->contractTpl()->count()) {
            return back()->withErrors('请先删除该模块下的所有模板');
        }
        if (!$contractTplSection->delete()) {
            return back()->withErrors(__('web.failed'));
        }
        return back()->with('message', __('web.success'));
    }
}
