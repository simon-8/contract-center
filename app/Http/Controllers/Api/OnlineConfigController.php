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
use Illuminate\Support\Facades\Cache;

class OnlineConfigController extends BaseController
{
    public function index(\Request $request)
    {
        $data = [
            'contractCategory' => Cache::get('contractCategoryUpdate')
        ];

        return responseMessage(__('api.success'), $data);
    }
}
