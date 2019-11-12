<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/8/12
 * Time: 20:33
 */
namespace App\Http\Controllers\Api;

use App\Models\Contract;
use App\Models\ContractCategory;
use App\Models\ContractTplSection;

class ContractCategoryController extends BaseController
{
    /**
     * @param \Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(\Request $request)
    {
        $data = $request::only(['company_id']);
        $lists = ContractCategory::ofCompanyId($data['company_id'] ?? 0)
        ->with([
            'tplSection' => function($query) {
                $query->orderByDesc('listorder');
            }
        ])->get();

        return responseMessage('', $lists);
    }

    /**
     * 详情
     * @param ContractCategory $contractCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ContractCategory $contractCategory)
    {
        $contractCategory->loadMissing([
            'tplSection' => function($query) {
                $query->orderByDesc('listorder');
            }
        ]);
        return responseMessage('', $contractCategory);
    }

    /**
     * 公司分类
     * @param \Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function company(\Request $request)
    {
        $data = $request::only(['company_id', 'keyword']);
        if (empty($data['company_id'])) {
            return responseException('参数缺失: company_id');
        }
        $lists = ContractCategory::ofCompanyId($data['company_id'] ?? 0)
            ->ofKeyword($data['keyword'] ?? '')
            ->with(['tplSection' => function($query) {
                $query->orderByDesc('listorder');
            }]);
        $tmp = $lists->get()->toArray();
        $lists = [];
        foreach ($tmp as $k => $v) {
            if (!$v['pid']) {
                $lists[$v['id']] = $v;
            }
        }

        foreach ($tmp as $k => $v) {
            if ($v['pid']) {
                $lists[$v['pid']]['child'][] = $v;
            }
        }
        sort($lists);
        $lists = collect($lists);
        return responseMessage('', $lists);
    }
}
