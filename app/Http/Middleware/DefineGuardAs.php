<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DefineGuardAs
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard)
    {
        if (isset($guard)) {
            config()->set('auth.defaults.guard',$guard);
            Auth::shouldUse($guard);
        }
        return $next($request);
    }
}
