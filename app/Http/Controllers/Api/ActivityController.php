<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/3/20
 * Time: 22:06
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Lottery;
use App\Models\LotteryApply;
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

    /**
     * PC端抽奖
     * @param \Request $request
     * @param ActivityRepository $repository
     * @return array|\Illuminate\Http\Response
     */
    public function postLottery(\Request $request, ActivityRepository $repository)
    {
        $data = $request::all();
        // todo 抽奖
        $activity = $repository->find($data['aid']);
        $lotteryApply = $activity->LotteryApply()->doesntHave('Lottery')->get();
        if ($data['giftNumber'] > $lotteryApply->count()) {
            if ($lotteryApply->count()) {
                return self::error('剩余获奖名额不足! 仅剩'. $lotteryApply->count() . '人未获奖');
            } else {
                return self::error('所有参与人员都已获奖, 无法继续抽奖!');
            }
        }
        $lotteryApply = $lotteryApply->random($data['giftNumber'])->all();
        foreach ($lotteryApply as $apply) {
            $lottery = Lottery::create([
                'apply_id' => $apply->id,
                'userid' => $apply->userid,
                'aid' => $apply->aid,
                'gid' => $data['giftID'],
                'truename' => $apply->truename,
                'mobile' => $apply->mobile,
                'admin_userid' => 0
            ]);
            $lottery->gname = $lottery->Gift->name;
            $lottery->save();
            unset($lottery->Gift);
            $lotterys[] = $lottery;
        }
        return $lotterys;
    }

    /**
     * 获取当前参与人数
     * @param ActivityRepository $repository
     * @param $aid
     * @return mixed
     */
    public function getActor(ActivityRepository $repository, $aid)
    {
        $activity = \Cache::remember('activity', 1, function() use ($repository, $aid) {
            return $repository->find($aid);
        });
        return $activity->actor;
    }
}