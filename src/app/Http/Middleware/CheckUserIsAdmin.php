<?php

namespace Lainga9\BallDeep\app\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Closure;

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
        $user = $request->user();

        if( ! ( $user && $user->isAn('admin') ) ) throw new AuthenticationException;

        return $next($request);
    }
}
