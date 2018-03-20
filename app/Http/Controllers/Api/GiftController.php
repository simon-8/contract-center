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
     * @param GiftRepository $repository
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getIndex(GiftRepository $repository)
    {
        return $repository->lists();
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