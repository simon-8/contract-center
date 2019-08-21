<?php
/**
 * Note: 用户
 * User: Liu
 * Date: 2018/11/13
 */
namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Services\ModelService;

class UserController extends BaseController
{

    public function index(\Request $request, User $user)
    {
        $data = $request::only(['created_at', 'type', 'keyword']);
        $lists = $user->ofCreatedAt($data['created_at'] ?? '');
        if (!empty($data['type']) && !empty($data['keyword'])) {
            $func = "of{$data['type']}";
            $lists->$func($data['keyword']);
        }

        $lists = $lists->paginate(ModelService::$pagesize);
        $lists->appends($data);
        return view('admin.user.index', compact('lists', 'data'));
    }

    /**
     * 冻结/解冻用户
     * @param \Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function freeze(\Request $request, User $user)
    {
        if (empty($user)) {
            return responseException(__('web.not_found'));
        }
        $user->is_block = intval(!$user->is_block);
        $user->save();
        return responseMessage(__('web.success'));
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('admin.user.show', compact('user'));
    }
}
