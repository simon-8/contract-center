<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/3/11
 * Time: 14:53
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\UserStore;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    /**
     * 列表
     * @param UserRepository $repository
     * @return mixed
     */
    public function getIndex(\Request $request, UserRepository $repository)
    {
        $keyword = $request::input('keyword');
        $lists = $repository->lists($keyword);
        $data = [
            'lists' => $lists,
            'keyword' => $keyword
        ];
        return admin_view('user.index' , $data);
    }

    /**
     * 删除
     * @param \Request $request
     * @param UserRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getDelete(\Request $request, UserRepository $repository)
    {
        $data = $request::all();
        if ($repository->delete($data['id'])) {
            return redirect()->route('admin.user.index')->with('Message' , '删除成功');
        } else {
            return back()->withErrors('删除失败')->withInput();
        }
    }
}