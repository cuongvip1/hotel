<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();

                if ($user->vai_tro === 'chu_tro') {
                    return redirect()->route('chu-tro.dashboard');
                }
                if ($user->vai_tro === 'khach_thue') {
                    return redirect()->route('khach-thue.dashboard');
                }
                if ($user->vai_tro === 'quan_tri') {
                    return redirect()->route('admin.dashboard');
                }

                return redirect('/');
            }
        }

        return $next($request);
    }
}