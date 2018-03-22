<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/3/20
 * Time: 22:05
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;

use App\Repositories\AdRepository;
use App\Repositories\ActivityRepository;
use App\Repositories\GiftRepository;

class IndexController extends ApiController
{
    /**
     * @param AdRepository $adRepository
     * @param ActivityRepository $activityRepository
     * @param GiftRepository $giftRepository
     * @param $aid
     * @return array
     */
    public function getIndex(AdRepository $adRepository, ActivityRepository $activityRepository, GiftRepository $giftRepository, $aid)
    {
        // todo 获取banner 指定活动信息 奖品列表
        $activity = $activityRepository->find($aid);
        if (empty($activity) || $activity->status < 1) {
            return [
                'banner' => [],
                'activity' => [],
                'gift' => []
            ];
        }
        $ad = $activity->AdPlace()->first()->ad;
        $gift = $activity->Gift;
        unset($activity->Gift);

        return [
            'banner' => $ad,
            'activity' => $activity,
            'gift' => $gift
        ];
    }
}