<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/6/13
 * Time: 23:36
 */
namespace App\Http\Controllers\Api;

use App\Models\ContractTpl;
use App\Models\ContractTplFill;
use App\Models\ContractTplRule;
use \DB;

class ContractTplController extends BaseController
{
    /**
     * 列表
     * @param \Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(\Request $request)
    {
        $data = $request::input(['section_id']);
        $lists = ContractTpl::ofSectionID($data['section_id'])->get();

        return responseMessage('', $lists);
    }
}
