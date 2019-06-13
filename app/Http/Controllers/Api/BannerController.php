<?php
/**
 * Note: banner
 * User: Liu
 * Date: 2019/06/13
 */
namespace App\Http\Controllers\Api;

use App\Models\Ad;

class BannerController
{
    /**
     * banner
     * @param Ad $ad
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Ad $ad, $id = 1)
    {
        $lists = $ad->ofPid($id)->select([
            'id',
            'thumb',
            'url',
            'title'
        ])->get()->toArray();
        return response_message('', $lists);
    }
}