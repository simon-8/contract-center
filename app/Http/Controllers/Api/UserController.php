<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/3/20
 * Time: 21:51
 */
namespace App\Http\Controllers\Api;
use App\Http\Controllers\ApiController;

use App\Repositories\UserRepository;
use App\Repositories\ActivityRepository;
use App\Models\User;
use App\Http\Requests\UserStore;

class UserController extends ApiController
{
    /**
     * @param UserRepository $repository
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getIndex(UserRepository $repository)
    {
        return $repository->lists();
    }

    /**
     * @param UserRepository $repository
     * @param $id
     * @return mixed|static
     */
    public function getOne(UserRepository $repository, $id)
    {
        return $repository->find($id);
    }

    /**
     * 获奖历史
     * @param UserRepository $userRepository
     * @param User $userModel
     * @param null $openid
     * @return array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection|null|object|static|static[]
     */
    public function getLotteryHistory(UserRepository $userRepository, User $userModel, $openid = null)
    {
        if (!empty($openid)) {
            $user = $userRepository->findByOpenID($openid);
            if (empty($user)) {
                return [];
            }
            $user->load('lottery');
            return $user;
        }
        $user = $userModel::has('lottery')->get();
        if (empty($user)) {
            return [];
        }
        $user->load('lottery');
        return $user;
    }

    /**
     * @param \Request $request
     * @param UserRepository $userRepository
     * @param ActivityRepository $activityRepository
     * @param null $aid
     * @return \Illuminate\Http\Response
     */
    public function postCreate(\Request $request, UserRepository $userRepository, ActivityRepository $activityRepository, $aid = null)
    {
        $activity = $activityRepository->find($aid);
        if (empty($activity) || $activity->status != 1) {
            return self::error('该活动已关闭');
        }
        if (strtotime($activity->end_time) < time()) {
            return self::error('该活动已结束');
        }

        $data = $request::all();
        $validator = UserStore::validateCreate($data);
        if ($validator->fails()) {
            return self::error($validator->messages()->first());
        }
        if ($userRepository->create($data)) {
            return self::success('操作成功');
        } else {
            return self::error();
        }
    }
}