<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsUserVerified
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
        if (Auth::user() &&  Auth::user()->verified === 1) {
            return $next($request);
        }
        $invalidAccount = "Аккаунт не активирован!";
        return response()->json(compact('invalidAccount'), 403);
    }
}
