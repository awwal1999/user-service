<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class IsLogin
{


    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws AuthenticationException
     */

    public function handle($request, Closure $next)
    {


        if (!Auth::guard()->check()) {
            throw new AuthenticationException();
        }
        return $next($request);

    }
}
