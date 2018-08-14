<?php
/*
 * 后台中间件
 * 必须登录后访问
 * */
namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

use App\Services\AuthService;

class AdminAuthenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth('admin')->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest(route('login.get'));
            }
        }

        // 权限检查
        $continue = (new AuthService())->checkPermission($request->user('admin'));
        if (!$continue) {
            abort(401, __('web.no_permission'));
        }

        return $next($request);
    }
}
