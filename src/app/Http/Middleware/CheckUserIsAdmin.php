<?php

namespace Lainga9\BallDeep\app\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Closure;
use Auth;

class CheckUserIsAdmin
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
        $user = Auth::guard('balldeep')->user();

        if( ! ( $user && $user->isAn('admin') ) ) abort(403);

        return $next($request);
    }
}
