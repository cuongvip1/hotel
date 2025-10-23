<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckWebAuth
{
    public function handle(Request $request, Closure $next)
    {
        $user = session('user');

        // Nếu chưa đăng nhập thì quay lại login
        if (!$user) {
            return redirect('/login')->with('error', 'Vui lòng đăng nhập trước.');
        }

        // Nếu là chủ trọ mà cố vào dashboard khách, hoặc ngược lại → chặn
        if ($request->is('chu-tro/*') && ($user['vai_tro'] ?? null) !== 'chu_tro') {
            return redirect('/')->with('error', 'Bạn không có quyền truy cập khu vực này.');
        }

        if ($request->is('khach-thue/*') && ($user['vai_tro'] ?? null) !== 'khach_thue') {
            return redirect('/')->with('error', 'Bạn không có quyền truy cập khu vực này.');
        }

        return $next($request);
    }
}
