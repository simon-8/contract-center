<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected $guards = null;

    /**
     * 重写认证方法
     * @param \Illuminate\Http\Request $request
     * @param array $guards
     * @throws AuthenticationException
     */
    protected function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }

        // 设置guards
        $this->guards = $guards;

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            }
        }

        throw new AuthenticationException(
            'Unauthenticated.', $guards, $this->redirectTo($request)
        );
    }
    /**
     * 重写跳转方法
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        $guard = array_shift($this->guards);
        if ($guard === 'admin') {
            if (! $request->expectsJson()) {
                return route('admin.login');
            }
        }

    }
}
