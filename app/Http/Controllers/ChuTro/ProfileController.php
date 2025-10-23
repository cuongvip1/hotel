<?php

namespace App\Http\Controllers\ChuTro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ApiClient;
use Illuminate\Support\Arr;

class ProfileController extends Controller
{
    protected ApiClient $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    /**
     * 🧩 Hiển thị hồ sơ cá nhân
     */
    public function show(Request $request)
    {
        $this->api->setToken(session('api_token'));

        // Gọi API lấy thông tin hồ sơ
        $profile = $this->api->get('chu-tro/profile');

        // Tránh lỗi nếu API không trả dữ liệu hợp lệ
        if (empty($profile) || !is_array($profile)) {
            $profile = session('user', []);
        }

        return view('chutro.profile', compact('profile'));
    }

    /**
     * 💾 Cập nhật hồ sơ (bao gồm upload ảnh)
     */
    public function update(Request $request)
    {
        $this->api->setToken(session('api_token'));

        $validated = $request->validate([
            'ho_ten' => 'required|string|max:255',
            'so_dien_thoai' => 'nullable|string|max:20',
            'anh_dai_dien' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        // Chuẩn bị dữ liệu gửi API
        $body = [
            'ho_ten' => $validated['ho_ten'],
            'so_dien_thoai' => $validated['so_dien_thoai'] ?? '',
        ];

        $files = [];
        if ($request->hasFile('anh_dai_dien')) {
            $files['anh_dai_dien'] = $request->file('anh_dai_dien');
        }

        // Gửi multipart request tới API backend
        $response = $this->api->postMultipart('chu-tro/update-profile', $body, $files);

        // Nếu API trả về user -> cập nhật session
        if (!empty($response['user'])) {
            $user = $response['user'];

            // Chuẩn hóa URL ảnh đại diện (nếu API chỉ trả đường dẫn tương đối)
            if (!empty($user['anh_dai_dien']) && !str_starts_with($user['anh_dai_dien'], 'http')) {
                $user['anh_dai_dien'] = rtrim(env('API_URL'), '/') . '/' . ltrim($user['anh_dai_dien'], '/');
            }

            // Cập nhật lại session
            session()->put('user', $user);
            session()->put('avatar_bust', time()); // cache-bust để header cập nhật ảnh mới
            session()->save();
        }

        // ✅ Reload avatar header bằng cách redirect lại kèm message
        return redirect()
            ->route('chu-tro.profile.show')
            ->with('success', 'Cập nhật hồ sơ thành công!');
    }
}
