<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/6/27
 */
namespace App\Http\Controllers\Api;

use App\Services\EsignService;

class SignController extends BaseController
{
    public function index(EsignService $esignService)
    {


        $busData = [];
        $esignService->busAdd([

        ]);
    }
}