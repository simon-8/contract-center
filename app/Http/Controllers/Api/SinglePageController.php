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
    public function index()
    {

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