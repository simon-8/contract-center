<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/6/27
 * Time: 23:11
 */
namespace App\Http\Controllers\Api;

use App\Models\UserAddress;
use App\Http\Resources\UserAddress as UserAddressResource;
use \DB;

class UserAddressController extends BaseController
{
    /**
     * @param UserAddress $userAddress
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(UserAddress $userAddress)
    {
        $lists = $userAddress->where('userid', $this->user->id)
            ->paginate();
        return UserAddressResource::collection($lists);
    }
}