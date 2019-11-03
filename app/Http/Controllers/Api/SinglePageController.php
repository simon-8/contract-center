<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/7/8
 */
namespace App\Http\Controllers\Api;

use App\Models\SinglePage;
use App\Http\Resources\SinglePage as SinglePageResource;

class SinglePageController extends BaseController
{
    /**
     * 首页
     * @param \Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(\Request $request)
    {
        $data = $request::all();
        $lists = SinglePage::select(['id', 'catid', 'title', 'thumb', 'listorder', 'status', 'created_at', 'updated_at'])
            ->ofCatid($data['catid'] ?? '')
            ->whereStatus(SinglePage::STATUS_NORMAL)
            ->orderByDesc('listorder')
            ->paginate(10);
        return SinglePageResource::collection($lists);
    }

    /**
     * 详情
     * @param SinglePage $singlePage
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(SinglePage $singlePage)
    {
        return responseMessage('', new SinglePageResource($singlePage));
    }
}
