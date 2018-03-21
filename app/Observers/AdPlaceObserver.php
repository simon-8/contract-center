<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/3/21
 * Time: 21:15
 */
namespace App\Observers;

use App\Models\AdPlace;

class AdPlaceObserver
{
    //public function created(AdPlace $adPlace)
    //{
    //
    //}

    /**
     * 删除对应广告
     * @param AdPlace $adPlace
     */
    public function deleted(AdPlace $adPlace)
    {
        $adPlace->ad()->delete();
    }
}