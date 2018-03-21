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

    public function postLottery(\Request $request, ActivityRepository $repository)
    {
        $data = $request::all();
        // todo 抽奖
        $activity = $repository->find($data['aid']);
        $lotteryApply = $activity->LotteryApply()->doesntHave('Lottery')->get();
        if ($data['giftNumber'] > $lotteryApply->count()) {
            return self::error('抽奖人数大于当前参与人数');
        }
        $lotteryApply = $lotteryApply->random($data['giftNumber'])->all();
        foreach ($lotteryApply as $apply) {
            $lottery = Lottery::create([
                'apply_id' => $apply->id,
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
}