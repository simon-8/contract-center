<?php

namespace App\Http\Middleware;

use Closure;

class AdminGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user('admin')) {
            return redirect('/' . config('admin.basePath'));
        }
        return $next($request);
    }
}
