<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/3/20
 * Time: 21:51
 */
namespace App\Http\Controllers\Api;
use App\Http\Controllers\ApiController;
use App\Repositories\GiftRepository;

class GiftController extends ApiController
{
    /**
     * @param \Request $request
     * @param GiftRepository $repository
     * @return \Illuminate\Http\Response
     */
    public function getIndex(\Request $request, GiftRepository $repository)
    {
        if (!$request::has('aid')) {
            return self::error('参数缺失');
        }
        $aid = $request::input('aid');
        return $repository->lists($aid);
    }

    /**
     * @param GiftRepository $repository
     * @param $id
     * @return mixed|static
     */
    public function getOne(GiftRepository $repository, $id)
    {
        return $repository->find($id);
    }
}