<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/3/20
 * Time: 22:06
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Repositories\ActivityRepository;

class ActivityController extends ApiController
{
    /**
     * @param ActivityRepository $repository
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getIndex(ActivityRepository $repository)
    {
        return $repository->lists();
    }

    /**
     * @param ActivityRepository $repository
     * @param $id
     * @return mixed|static
     */
    public function getOne(ActivityRepository $repository, $id)
    {
        return $repository->find($id);
    }
}