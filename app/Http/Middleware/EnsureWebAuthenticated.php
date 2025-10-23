<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureWebAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('user') && session()->has('api_token')) {
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
    }
}
