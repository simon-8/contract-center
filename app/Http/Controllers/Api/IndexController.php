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

        $ad = $adRepository->find(1)->ad()->orderByDesc('listorder')->get();

        $activity = $activityRepository->find($aid);

        $gift = $giftRepository->lists(6);

        return [
            'banner' => $ad,
            'activity' => $activity,
            'gift' => $gift
        ];
    }
}