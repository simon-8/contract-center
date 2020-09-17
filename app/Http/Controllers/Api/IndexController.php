<?php
/**
 * Note: *
 * User: Liu
 * Date: 2020/9/17
 * Time: 21:20
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\EsignFaceService;

class IndexController extends Controller
{
    public function test(EsignFaceService $service)
    {
        $url = $service->getFaceUrl('A61B017D62AD4D0AB76AB29C85D3D2A8');
        info(__METHOD__);
        dd($url);
    }
}
