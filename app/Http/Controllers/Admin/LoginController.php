<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin.guest')->except('logout');
    }

    /**
     * 替代$redirectTo属性 优先级更大
     * @return string
     */
    protected function redirectTo()
    {
        return '/' . config('admin.basePath');
    }

    /**
     * 自定义用户名
     * @return string
     */
    protected function username()
    {
        return 'username';
    }

    /**
     * 自定义Guard
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return \Auth::guard('admin');
    }

    /**
     * 显示登录模板
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        return admin_view('auth.login');
    }

    /**
     * 校验规则
     * @param Request $request
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
            'captcha'  => 'required|captcha'
        ]);
    }

    /**
     * 用户通过认证 记录登录时间/IP
     * @param Request $request
     * @param $user
     */
    protected function authenticated(Request $request, $user)
    {
        $user->lasttime = date('Y-m-d H:i:s');
        $user->lastip = $request->ip();
        $user->save();
    }

    /**
     * 退出登录
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect($this->redirectTo());
    }
}
