<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }
    public function login(Request $request)
    {
        // Validation
        $credentials = $request->validate([
            // 'email' => 'required|email',
            // 'password' => 'required|min:8',
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        // Check user exists, role is admin, and status is active.
        $user = User::where('email', $credentials['email'])
            ->where('role', 'admin')
            ->where('status', 1)
            ->first();
        // Authentication
        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            $request->session()->regenerate(); //tao moi phien
            //get user
            $userName = Auth::user()->name;
            $request->session()->put('name', $userName);

            return redirect()->route('admin.dashboard');
        }
        // if (Auth::attempt([x
        //     'email' => $credentials['email'],
        //     'password' => $credentials['password'],
        //     'role' => 'admin',
        //     'status' => 1,
        // ])) {
        //     $request->session()->regenerate();
        //     return redirect()->intended('/admin/dashboard');
        // }
        return back()->withErrors(['email' => 'Thông tin đăng nhập không hợp lệ hoặc tài khoản của bạn đã bị khóa.']);
    }
    public function logout(Request $request)
    {
        Auth::logout(); // Đăng xuất người dùng

        $request->session()->invalidate(); // Hủy session hiện tại
        $request->session()->regenerateToken(); // Tạo token CSRF mới để tránh tấn công CSRF

        return redirect()->route('admin.login'); // Chuyển hướng về trang đăng nhập
    }
}