<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/6/13
 * Time: 23:36
 */
namespace App\Http\Controllers\Api;

use App\Http\Resources\ContractTemplate AS ContractTemplateResource;
use App\Models\ContractTemplate;
use \DB;

class ContractTemplateController extends BaseController
{
    /**
     * 列表
     * @param \Request $request
     * @param ContractTemplate $contractTemplate
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(\Request $request, ContractTemplate $contractTemplate)
    {
        $lists = $contractTemplate->get();
        return responseMessage('', ContractTemplateResource::collection($lists));
    }
}