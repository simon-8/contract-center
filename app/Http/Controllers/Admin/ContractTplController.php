<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ContractTplRequest;
use App\Models\ContractTpl;
use App\Models\ContractTplSection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContractTplController extends Controller
{
    /**
     * @param \Request $request
     * @param ContractTpl $contractTpl
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(\Request $request, ContractTpl $contractTpl)
    {
        $data = $request::only(['created_at', 'content', 'section_id']);
        $lists = $contractTpl->ofCatid($data['catid'] ?? '')
            ->ofCreatedAt($data['created_at'] ?? '')
            ->ofContent($data['content'] ?? '')
            ->ofSectionId($data['section_id'] ?? '')
            ->orderByDesc('id')
            ->paginate();
        return view('admin.contract_tpl.index', compact('lists', 'data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.contract_tpl.create');
    }

    /**
     * @param ContractTplRequest $request
     * @param ContractTpl $contractTpl
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(ContractTplRequest $request, ContractTpl $contractTpl)
    {
        $data = $request->all();
        $request->validateStore($data);

        if (strpos($data['content'], ContractTpl::FILL_STRING) !== false) {
            $arr = explode(ContractTpl::FILL_STRING, strip_tags($data['content']));
            $newArr = [];
            array_map(function($item) use(&$newArr) {
                $newArr[] = $item;
                $newArr[] = [
                    'type' => 'input',
                ];
            }, $arr);
            $data['formdata'] = array_slice($newArr, 0, -1);
        }
        $section = ContractTplSection::find($data['section_id']);
        $data['catid'] = $section['catid'];
        $data['players'] = $section['players'];
        if (!$contractTpl->create($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }

        return redirect()->route('admin.contract-tpl.index')->with('message', __('web.success'));
    }

    /**
     * @param ContractTpl $contractTpl
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(ContractTpl $contractTpl)
    {
        return view('admin.contract_tpl.create', compact('contractTpl'));
    }

    /**
     * @param ContractTplRequest $request
     * @param ContractTpl $contractTpl
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(ContractTplRequest $request, ContractTpl $contractTpl)
    {
        $data = $request->all();
        $request->validateUpdate($data);

        if (strpos($data['content'], ContractTpl::FILL_STRING) !== false) {
            $arr = explode(ContractTpl::FILL_STRING, strip_tags($data['content']));
            $newArr = [];
            array_map(function($item) use(&$newArr) {
                $newArr[] = $item;
                $newArr[] = [
                    'type' => 'input',
                ];
            }, $arr);

            $data['formdata'] = array_slice($newArr, 0, -1);
        }

        $section = ContractTplSection::find($data['section_id']);
        $data['catid'] = $section['catid'];
        $data['players'] = $section['players'];
        if (!$contractTpl->update($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }

        return redirect()->route('admin.contract-tpl.index')->with('message', __('web.success'));
    }

    /**
     * @param ContractTpl $contractTpl
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(ContractTpl $contractTpl)
    {
        if (!$contractTpl->delete()) {
            return back()->withErrors(__('web.failed'));
        }
        return redirect()->route('admin.contract-tpl.index')->with('message', __('web.success'));
    }
}
