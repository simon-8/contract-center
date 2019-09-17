<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ContractTplFillRequest;
use App\Models\ContractTplFill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContractTplFillController extends Controller
{
    /**
     * @param \Request $request
     * @param ContractTplFill $contractTplFill
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(\Request $request, ContractTplFill $contractTplFill)
    {
        $data = $request::only(['created_at', 'content', 'catid', 'formname']);
        $lists = $contractTplFill->ofCatid($data['catid'] ?? '')
            ->ofCreatedAt($data['created_at'] ?? '')
            ->ofContent($data['content'] ?? '')
            ->orderByDesc('id')
            ->paginate();
        return view('admin.contract_tpl_fill.index', compact('lists', 'data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.contract_tpl_fill.create');
    }

    /**
     * @param ContractTplFillRequest $request
     * @param ContractTplFill $contractTplFill
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ContractTplFillRequest $request, ContractTplFill $contractTplFill)
    {
        $data = $request->all();
        //$data['avatar'] = upload_base64_thumb($data['avatar']);
        $request->validateCreate($data);

        if (!$contractTplFill->create($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }

        return redirect()->route('admin.contract-tpl-fill.index')->with('message', __('web.success'));
    }

    /**
     * @param ContractTplFill $contractTplFill
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(ContractTplFill $contractTplFill)
    {
        return view('admin.contract_tpl_fill.create', compact('contractTplFill'));
    }

    /**
     * @param ContractTplFillRequest $request
     * @param ContractTplFill $contractTplFill
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ContractTplFillRequest $request, ContractTplFill $contractTplFill)
    {
        $data = $request->all();
        $request->validateUpdate($data);

        $data['formname'] = pinyin_permalink($data['content'], '');
        if (!$contractTplFill->update($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }

        return redirect()->route('admin.contract-tpl-fill.index')->with('message', __('web.success'));
    }

    /**
     * @param ContractTplFill $contractTplFill
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(ContractTplFill $contractTplFill)
    {
        if (!$contractTplFill->delete()) {
            return back()->withErrors(__('web.failed'));
        }
        return redirect()->route('admin.contract-tpl-fill.index')->with('message', __('web.success'));
    }
}
