<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $level)
    {
        if (auth()->user()->level == "admin") {
            return $next($request);
        }else{
            if (auth()->user()->level == $level) {
                return $next($request);
            }
        }

        alert()->warning('You dont have access', 'this page just for admin');
        return back();
    }
}
