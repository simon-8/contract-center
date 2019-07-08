<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ContractTplRuleRequest;
use App\Models\ContractTplRule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContractTplRuleController extends Controller
{
    /**
     * @param \Request $request
     * @param ContractTplRule $contractTplRule
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(\Request $request, ContractTplRule $contractTplRule)
    {
        $data = $request::only(['created_at', 'content', 'catid']);
        $lists = $contractTplRule->ofCatid($data['catid'] ?? '')
            ->ofCreatedAt($data['created_at'] ?? '')
            ->ofContent($data['content'] ?? '')
            ->orderByDesc('id')
            ->paginate();
        return view('admin.contract_tpl_rule.index', compact('lists', 'data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.contract_tpl_rule.create');
    }

    /**
     * @param ContractTplRuleRequest $request
     * @param ContractTplRule $contractTplRule
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ContractTplRuleRequest $request, ContractTplRule $contractTplRule)
    {
        $data = $request->all();
        //$data['avatar'] = upload_base64_thumb($data['avatar']);
        $request->validateCreate($data);

        if (!$contractTplRule->create($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }

        return redirect()->route('admin.contract-tpl-rule.index')->with('message', __('web.success'));
    }

    /**
     * @param ContractTplRule $contractTplRule
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(ContractTplRule $contractTplRule)
    {
        return view('admin.contract_tpl_rule.create', compact('contractTplRule'));
    }

    /**
     * @param ContractTplRuleRequest $request
     * @param ContractTplRule $contractTplRule
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ContractTplRuleRequest $request, ContractTplRule $contractTplRule)
    {
        $data = $request->all();
        $request->validateUpdate($data);

        if (!$contractTplRule->update($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }

        return redirect()->route('admin.contract-tpl-rule.index')->with('message', __('web.success'));
    }

    /**
     * @param ContractTplRule $contractTplRule
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(ContractTplRule $contractTplRule)
    {
        if (!$contractTplRule->delete()) {
            return back()->withErrors(__('web.failed'));
        }
        return redirect()->route('admin.contract-tpl-rule.index')->with('message', __('web.success'));
    }
}
