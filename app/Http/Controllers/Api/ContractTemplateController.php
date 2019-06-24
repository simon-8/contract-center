<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/6/13
 * Time: 23:36
 */
namespace App\Http\Controllers\Api;

use App\Models\ContractTplFill;
use App\Models\ContractTplRule;
use \DB;

class ContractTemplateController extends BaseController
{
    /**
     * 列表
     * @param \Request $request
     * @param ContractTplFill $contractTplFill
     * @param ContractTplRule $contractTplRule
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(\Request $request, ContractTplFill $contractTplFill, ContractTplRule $contractTplRule)
    {
        $fills = $contractTplFill->get()->map(function ($fill) {
            unset($fill['listorder'], $fill['created_at'], $fill['updated_at']);
            return $fill;
        });
        $rules = $contractTplRule->get()->map(function ($rule) {
            unset($rule['listorder'], $rule['created_at'], $rule['updated_at']);
            return $rule;
        });
        
        return responseMessage('', compact('fills', 'rules'));
    }
}