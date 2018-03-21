<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/3/21
 * Time: 20:50
 */
namespace App\Observers;

use App\Models\Activity;
use App\Models\AdPlace;

class ActivityObserver
{
    /**
     * 创建对应广告位
     * @param Activity $activity
     */
    public function created(Activity $activity)
    {
        AdPlace::create([
            'aid' => $activity->id,
            'name' => '活动编号'. $activity->id .'的Banner',
            'width' => AdPlace::$defaultWidth,
            'height' => AdPlace::$defaultHeight,
            'status' => 1
        ]);
    }

    /**
     * 删除时删除对应广告
     * @param Activity $activity
     * @throws \Exception
     */
    public function deleted(Activity $activity)
    {
        $adPlace = $activity->AdPlace()->first();
        $adPlace->delete();
    }
}