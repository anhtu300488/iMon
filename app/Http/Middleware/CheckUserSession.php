<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userhash   = \Session::get('session_id');
        $sessionId = \Session::getId();
        if (isset(auth()->user()->session_id) && auth()->user()->session_id != $userhash) {
            \Session::getHandler()->destroy($sessionId);
            \Auth::logout();
            return redirect('/');
        }

        return $next($request);
    }
}
