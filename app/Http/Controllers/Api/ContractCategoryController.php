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
        $data = [];
        ContractCategory::get()->each(function($v) use (&$data) {
            $info = $v->toArray();
            $players = (new Contract())->getPlayers();
            foreach ($players as $playerId => $playerName) {
                $sections = ContractTplSection::ofCatid($v->id)
                    ->ofPlayers($playerId)
                    //->with(['contract-tpl' => function ($query) {
                    //    $query->select([''])->orderByDesc('listorder');
                    //}])
                    ->orderByDesc('listorder')
                    ->get();
                $info['sections'][$playerId] = $sections;
            }
            $data[] = $info;
        });

        return responseMessage('', $data);
    }
}
