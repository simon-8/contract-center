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
        $data = $request::only(['created_at', 'content', 'section_id', 'players']);
        $lists = $contractTpl->ofCatid($data['catid'] ?? '')
            ->ofCreatedAt($data['created_at'] ?? '')
            ->ofContent($data['content'] ?? '')
            ->ofSectionId($data['section_id'] ?? '')
            ->ofPlayers($data['players'] ?? '')
            ->orderByDesc('id')
            ->paginate();
        return view('admin.contract_tpl.index', compact('lists', 'data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(\Request $request)
    {
        $contractTpl = $request::all();
        return view('admin.contract_tpl.create', compact('contractTpl'));
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
        } else {
            $data['formdata'] = [strip_tags($data['content'])];
        }
        $section = ContractTplSection::find($data['section_id']);
        $data['catid'] = $section['catid'];
        $data['players'] = $section['players'];
        if (!$contractTpl->create($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }

        return redirect()->route('admin.contract-tpl.index', [
            'section_id' => $data['section_id'],
            'players' => $data['players'],
        ])->with('message', __('web.success'));
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

        $content = $data['content'];
        $content = str_replace('<p>', '', $content);
        $content = str_replace('</p>', '<br/>', $content);

        if (strpos($content, ContractTpl::FILL_STRING) !== false) {
            $arr = explode(ContractTpl::FILL_STRING, strip_tags($content));
            $newArr = [];
            array_map(function($item) use(&$newArr) {
                $newArr[] = $item;
                $newArr[] = [
                    'type' => 'input',
                ];
            }, $arr);

            $data['formdata'] = array_slice($newArr, 0, -1);
        } else {
            $data['formdata'] = [$content];
        }

        foreach ($data['formdata'] as $k => $item) {
            if (strpos($item, '<br/>') !== false) {
                $arr = explode('<br/>', $item);
                $newArr = [];
                array_map(function($item) use(&$newArr) {
                    $newArr[] = strip_tags($item);
                    $newArr[] = [
                        'type' => 'br',
                    ];
                }, $arr);
                dd($content, $data['formdata'], $newArr);
                array_splice($data['formdata'], $k, 1, $newArr);
                $data['formdata'][$k] = $newArr;
            } else {
                $data['formdata'][$k] = strip_tags($item);
            }
        }
        dd($data['formdata']);
        $section = ContractTplSection::find($data['section_id']);
        $data['catid'] = $section['catid'];
        $data['players'] = $section['players'];
        if (!$contractTpl->update($data)) {
            return back()->withErrors(__('web.failed'))->withInput();
        }

        return redirect()->route('admin.contract-tpl.index', [
            'section_id' => $data['section_id'],
            'players' => $data['players'],
        ])->with('message', __('web.success'));
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
        return redirect()->route('admin.contract-tpl.index', [
            'section_id' => $contractTpl['section_id'],
            'players' => $contractTpl['players'],
        ])->with('message', __('web.success'));
    }
}
