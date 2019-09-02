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
    public function index(\Request $request)
    {
        $data = ContractCategory::with(['tplSection' => function($query) {
            $query->orderByDesc('listorder');
        }])->get();

        return responseMessage('', $data);
    }
}
