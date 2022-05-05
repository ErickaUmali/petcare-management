<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GuestOrClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ((auth()->user() && auth()->user()->role == 3) || !auth()->user()) {
            return $next($request);
        }
        return redirect()->route('dashboard.index');
    }
}
