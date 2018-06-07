<?php

namespace Lainga9\BallDeep\app\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Closure;
use Auth;

class CheckUserIsBallDeep
{
    /**
     * Check whether the user has an assigned role
     * from the balldeep package
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::guard('balldeep')->user();

        if( ! $user ) return redirect()->route('balldeep.login');

        return $next($request);
    }
}
