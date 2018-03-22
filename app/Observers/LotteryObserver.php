<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/3/22
 * Time: 0:58
 */
namespace App\Observers;

use App\Models\Lottery;
use App\Models\Gift;

class LotteryObserver
{
    /**
     * 中奖后增加奖品销量
     * @param Lottery $lottery
     */
    public function created(Lottery $lottery)
    {
        Gift::find($lottery->gid)->increment('sales', 1);
    }

}