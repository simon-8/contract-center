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
        $data = $request::only(['rangeDate', 'type', 'keyword']);
        $lists = $user->ofCreatedAt($data['rangeDate'] ?? '');
        if (!empty($data['type']) && !empty($data['keyword'])) {
            $func = "of{$data['type']}";
            $lists->$func($data['keyword']);
        }

        $lists = $lists->paginate(ModelService::$pagesize);
        $lists->appends($data);
        return view('admin.user.index', compact('lists', 'data'));
    }
}