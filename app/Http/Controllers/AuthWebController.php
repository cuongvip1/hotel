<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

class AuthWebController extends Controller
{
    protected ApiClient $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    // =======================
    // 🧩 HIỂN THỊ FORM LOGIN
    // =======================
    public function showLogin()
    {
        return view('auth.login');
    }

    // =======================
    // 🔑 XỬ LÝ ĐĂNG NHẬP
    // =======================
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'mat_khau' => 'required|string|min:3',
        ]);

        $apiUrl = rtrim(config('services.api.base'), '/');

        try {
            $response = Http::timeout(10)
                ->post("$apiUrl/auth/login", $credentials)
                ->json();
        } catch (\Throwable $e) {
            return back()->with('error', '❌ Không thể kết nối API: ' . $e->getMessage());
        }

        if (empty($response['token'])) {
            return back()->with('error', 'Sai email hoặc mật khẩu!')->withInput();
        }

        // ✅ Lưu token vào SESSION + COOKIE
        session(['api_token' => $response['token']]);
        session()->save(); // ⚡ QUAN TRỌNG — đảm bảo token được ghi ngay
        Cookie::queue('api_token', $response['token'], 60 * 24 * 7);

        // 🧠 Lấy thông tin user /me
        try {
            $profile = Http::withToken($response['token'])
                ->timeout(10)
                ->get("$apiUrl/me")
                ->json();
        } catch (\Throwable $e) {
            return redirect('/')->with('error', 'Không thể tải thông tin người dùng: ' . $e->getMessage());
        }

        if (!$profile || !is_array($profile)) {
            return redirect('/')->with('error', 'Không lấy được thông tin người dùng.');
        }

        if (empty($profile['anh_dai_dien'])) {
            $profile['anh_dai_dien'] = '/images/default-avatar.png';
        }

        session([
            'user' => $profile,
            'avatar_bust' => time(),
        ]);

        $role = $profile['vai_tro'] ?? 'nguoi_dung';

        $messages = [
            'quan_tri' => '👑 Chào mừng Quản trị viên!',
            'chu_tro' => '🏠 Xin chào Chủ trọ!',
            'khach_thue' => '🎉 Chào mừng bạn trở lại!',
            'nguoi_dung' => '🎉 Đăng nhập thành công!',
        ];

        \Log::info('✅ LOGIN SUCCESS', [
            'user' => $profile['email'] ?? 'unknown',
            'token' => substr($response['token'], 0, 20) . '...',
        ]);

        return redirect('/')->with('ok', $messages[$role] ?? $messages['nguoi_dung']);
    }


    // =======================
    // 🚪 ĐĂNG XUẤT
    // =======================
    public function logout(Request $request)
    {
        try {
            if (session('api_token')) {
                $this->api->setToken(session('api_token'));
                $this->api->post('auth/logout');
            }
        } catch (\Throwable $e) {
            \Log::error('❌ Lỗi khi logout API', ['error' => $e->getMessage()]);
        }

        session()->flush();
        Cookie::queue(Cookie::forget('api_token'));

        return redirect('/')->with('ok', 'Đã đăng xuất!');
    }

    // =======================
    // 📝 FORM ĐĂNG KÝ
    // =======================
    public function showRegister()
    {
        return view('auth.register');
    }

    // =======================
    // 🧩 XỬ LÝ ĐĂNG KÝ
    // =======================
    public function register(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_number' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:khach_thue,chu_tro,quan_tri',
        ]);

        $payload = [
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'password' => $data['password'],
            'password_confirmation' => $request->input('password_confirmation'),
            'role' => $data['role'],
        ];

        $apiUrl = rtrim(config('services.api.base'), '/');

        try {
            $response = Http::timeout(10)->post("$apiUrl/auth/register", $payload);

            if ($response->failed()) {
                // 🆕 Hiển thị rõ lỗi từ API (nếu có)
                $msg = $response->json('message') ?? 'Lỗi không xác định từ API.';
                return back()->with('error', '❌ Đăng ký thất bại: ' . $msg)->withInput();
            }

            return redirect('/login')->with('ok', '🎉 Đăng ký thành công! Hãy đăng nhập.');

        } catch (\Throwable $e) {
            return back()->with('error', '⚠️ Không thể kết nối API: ' . $e->getMessage())->withInput();
        }
    }
}
