<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/3/21
 * Time: 23:16
 */
namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;

use App\Models\LotteryApply;
use App\Repositories\ActivityRepository;

class ActivityController extends Controller
{
    public function getActivity(\Request $request, ActivityRepository $activityRepository, $aid)
    {
        $aid = decrypt($aid);
        if (!is_numeric($aid)) {
            abort(404);
        }
        $activity = $activityRepository->find($aid);
        //$applys = LotteryApply::where('aid', $aid)->get();
        return home_view('activity.lottery', [
            'activity' => $activity
        ]);
    }
}