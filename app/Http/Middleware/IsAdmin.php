<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra xem người dùng đã đăng nhập và có role là 'admin' chưa
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request); // Cho phép tiếp tục truy cập nếu là admin
        }

        // Nếu không phải admin, chuyển hướng về trang khác (ví dụ: trang chủ)
        return redirect('/')->with('error', 'Bạn không có quyền truy cập vào trang này.');
    }
}