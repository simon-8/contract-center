<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/3/22
 * Time: 0:58
 */
namespace App\Observers;

use App\Models\LotteryApply;
use App\Models\Activity;

class LotteryApplyObserver
{
    /**
     * @param LotteryApply $lotteryApply
     */
    public function created(LotteryApply $lotteryApply)
    {
        Activity::find($lotteryApply->aid)->increment('actor', 1);
    }

}