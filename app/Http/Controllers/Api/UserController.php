<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/3/20
 * Time: 21:51
 */
namespace App\Http\Controllers\Api;
use App\Http\Controllers\ApiController;

use App\Models\Lottery;
use App\Repositories\UserRepository;
use App\Repositories\ActivityRepository;

use App\Models\User;
use App\Models\LotteryApply;
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
     * 获取用户信息
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
     * @param $aid
     * @param null $openid
     * @return array|\Illuminate\Database\Eloquent\Model|null|object|static
     */
    public function getLotteryHistory(UserRepository $userRepository, User $userModel, $aid, $openid = null)
    {
        if (!empty($openid)) {
            $user = $userRepository->findByOpenID($openid);
            if (empty($user)) {
                return [];
            }
            $user->load([
                'lottery' => function($query) use ($aid) {
                    $query->where('aid', $aid);
                }
            ]);
            return $user->lottery;
        }
        return Lottery::where('aid', $aid)->get();
    }

    /**
     * 登记
     * @param \Request $request
     * @param UserRepository $userRepository
     * @param ActivityRepository $activityRepository
     * @param null $aid
     * @return \Illuminate\Http\Response
     */
    public function postCheckIn(\Request $request, UserRepository $userRepository, ActivityRepository $activityRepository, $aid = null)
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
        // 使用mobile代替openid
        if (empty($data['openid'])) $data['openid'] = $data['mobile'];
        $user = $userRepository->updateOrCreate($data);
        if (!$user) {
            return self::error('报名失败');
        }

        $condition = [
            'aid' => $aid,
            'userid' => $user->id
        ];
        $lotteryApply = LotteryApply::where($condition)->first();
        if (!empty($lotteryApply)) {
            return self::error('您已报名, 不可重复报名');
        }

        $lotteryApply = LotteryApply::create(
            array_merge($condition, [
                'truename' => $user->truename,
                'mobile'   => $user->mobile
            ])
        );
        if ($lotteryApply->id) {
            return self::response('操作成功');
        } else {
            return self::error('操作失败');
        }
    }
}