<?php

namespace App\Http\Controllers\Admin;

use App\Models\ContractTemplate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContractTemplateController extends Controller
{
    /**
     * @param \Request $request
     * @param ContractTemplate $contractTemplate
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(\Request $request, ContractTemplate $contractTemplate)
    {
        $data = $request::only(['created_at', 'content', 'catid', 'typeid']);
        $lists = $contractTemplate->ofCatid($data['catid'] ?? 0)
            ->ofTypeid($data['typeid'] ?? 0)
            ->ofCreatedAt($data['created_at'] ?? '')
            ->ofContent($data['content'] ?? '')
            ->paginate();
        return view('admin.contract_template.index', compact('lists', 'data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.contract_template.create');
    }

    /**
     * @param \Request $request
     * @param ContractTemplate $contractTemplate
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(\Request $request, ContractTemplate $contractTemplate)
    {
        $data = $request::all();
        //$data['avatar'] = upload_base64_thumb($data['avatar']);
        //$request->validateCreate($data);

        if (!$contractTemplate->create($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }

        return redirect()->route('admin.contract-template.index')->with('message', __('web.success'));
    }

    /**
     * @param ContractTemplate $contractTemplate
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(ContractTemplate $contractTemplate)
    {
        return view('admin.contract_template.create', compact('contractTemplate'));
    }

    /**
     * @param Request $request
     * @param ContractTemplate $contractTemplate
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(\Request $request, ContractTemplate $contractTemplate)
    {
        $data = $request::all();

        if (!$contractTemplate->update($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }

        return redirect()->route('admin.contract-template.index')->with('message', __('web.success'));
    }

    /**
     * @param ContractTemplate $contractTemplate
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(ContractTemplate $contractTemplate)
    {
        if (!$contractTemplate->delete()) {
            return back()->withErrors(__('web.failed'));
        }
        return redirect()->route('admin.contract-template.index')->with('message', __('web.success'));
    }
}
