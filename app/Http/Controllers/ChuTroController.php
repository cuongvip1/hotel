<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class ChuTroController extends Controller
{
    private ApiClient $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    /** 🏠 Dashboard */
    public function dashboard(Request $request)
    {
        $this->api->setToken(session('api_token'));
        $data = $this->api->get('/chu-tro/dashboard');

        $stats = [
            'so_day_tro' => $data['so_day_tro'] ?? 0,
            'so_phong' => $data['so_phong'] ?? 0,
            'so_phong_trong' => $data['so_phong_trong'] ?? 0,
            'so_phong_dang_thue' => $data['so_phong_dang_thue'] ?? 0,
            'so_phong_dang_sua' => $data['so_phong_dang_sua'] ?? 0,
            'doanh_thu_thang' => $data['doanh_thu_thang'] ?? 0,
        ];

        return view('chutro.dashboard', [
            'stats' => $stats,
            'doanh_thu_6_thang' => $data['doanh_thu_6_thang'] ?? [],
            'bai_dang_gan_day' => $data['bai_dang_gan_day'] ?? [],
            'hoat_dong_gan_day' => $data['hoat_dong_gan_day'] ?? [],
        ]);
    }

    /** 📋 Danh sách bài đăng + filter */
    public function index(Request $request)
    {
        $this->api->setToken(session('api_token'));

        $query = \Illuminate\Support\Arr::only($request->all(), [
            'search',
            'trang_thai',
            'sort',
            'phong_id',
            'day_tro_id',
            'page'
        ]);

        // 🟩 Thêm log để theo dõi
        \Log::info('🟦 [ChuTroController@index] Token hiện tại:', ['token' => session('api_token')]);
        \Log::info('🟦 [ChuTroController@index] Query:', $query);

        try {
            $res = $this->api->get('/chu-tro/bai-dang', $query);

            // Ghi log dữ liệu trả về từ API
            \Log::info('🟩 [ChuTroController@index] API /chu-tro/bai-dang trả về:', [
                'type' => gettype($res),
                'keys' => is_array($res) ? array_keys($res) : 'not array',
                'preview' => substr(json_encode($res), 0, 500) . '...'
            ]);

            if ($res instanceof \Illuminate\Http\Client\Response) {
                $res = $res->json();
            }

            if (is_array($res) && isset($res['data'])) {
                $posts = new LengthAwarePaginator(
                    $res['data'],
                    $res['total'] ?? count($res['data']),
                    $res['per_page'] ?? 12,
                    $res['current_page'] ?? 1,
                    ['path' => $request->url(), 'query' => $request->query()]
                );
            } else {
                $data = is_array($res) ? $res : [];
                $page = (int) ($request->input('page', 1));
                $perPage = 12;
                $slice = array_slice($data, ($page - 1) * $perPage, $perPage);
                $posts = new LengthAwarePaginator($slice, count($data), $perPage, $page, [
                    'path' => $request->url(),
                    'query' => $request->query(),
                ]);
            }

            $rooms = $this->api->get('/chu-tro/phong') ?? [];
            $blocks = $this->api->get('/chu-tro/day-tro') ?? [];

        } catch (\Throwable $e) {
            \Log::error('🟥 [ChuTroController@index] Lỗi khi gọi API /chu-tro/bai-dang', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $posts = new LengthAwarePaginator([], 0, 12);
            $rooms = $blocks = [];
        }

        return view('chutro.index', compact('posts', 'rooms', 'blocks'));
    }



    /** ➕ Trang tạo */
    public function create()
    {
        $this->api->setToken(session('api_token'));

        try {
            $phong = $this->api->get('/chu-tro/phong') ?: $this->api->get('/phong'); // fallback
        } catch (\Throwable $e) {
            $phong = [];
        }

        // tiện ích: nếu bạn có endpoint riêng, thay '/tien-ich'
        try {
            $tienIch = $this->api->get('/tien-ich') ?? [];
        } catch (\Throwable $e) {
            $tienIch = [];
        }

        return view('chutro.create', ['phong' => $phong, 'tienIch' => $tienIch]);
    }

    /** 💾 Lưu bài đăng */
    /** 💾 Lưu bài đăng */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'phong_id' => 'required|integer',
            'tieu_de' => 'required|max:255',
            'mo_ta' => 'required|string',
            'gia_niem_yet' => 'required|numeric|min:0',
            'trang_thai' => 'required|in:nhap,dang,an', // 🟢 thêm validate trạng thái
            'tien_ich' => 'array',               // optional
            'anh.*' => 'image|max:5120',         // 5MB/ảnh
        ]);

        $this->api->setToken(session('api_token'));

        // 1️⃣ Chuẩn bị dữ liệu gửi API
        $payload = Arr::only($validated, [
            'phong_id',
            'tieu_de',
            'mo_ta',
            'gia_niem_yet',
            'trang_thai' // 🟢 gửi thêm trạng thái
        ]);
        $payload['tien_ich'] = $request->input('tien_ich', []);

        try {
            // 2️⃣ Gửi yêu cầu tạo bài đăng
            $created = $this->api->post('/bai-dang', $payload);
        } catch (\Throwable $e) {
            return back()->with('error', 'Không thể tạo bài đăng: ' . $e->getMessage())->withInput();
        }

        // 3️⃣ Upload ảnh (nếu có)
        if ($request->hasFile('anh')) {
            try {
                $this->api->postMultipart(
                    '/anh-bai-dang/upload',
                    ['bai_dang_id' => $created['id'] ?? null],
                    ['anh[]' => $request->file('anh')]
                );
            } catch (\Throwable $e) {
                // fallback (nếu API chính không nhận)
                try {
                    $this->api->postMultipart(
                        '/bai-dang/' . ($created['id'] ?? 0) . '/anh',
                        [],
                        ['anh[]' => $request->file('anh')]
                    );
                } catch (\Throwable $e2) {
                    Log::error('Upload ảnh thất bại', ['e' => $e2->getMessage()]);
                }
            }
        }

        // 4️⃣ Redirect về danh sách
        return redirect()
            ->route('chu-tro.bai-dang.index')
            ->with('ok', 'Đã tạo bài đăng thành công!');
    }


    /** ✏️ Sửa */
    public function edit(int $id)
    {
        $this->api->setToken(session('api_token'));

        try {
            $post = $this->api->get("/bai-dang/{$id}");
            $phong = $this->api->get('/chu-tro/phong') ?: $this->api->get('/phong');
            $tienIch = $this->api->get('/tien-ich') ?? [];
        } catch (\Throwable $e) {
            return redirect()->route('chu-tro.bai-dang.index')->with('error', 'Không tải được dữ liệu.');
        }

        // danh sách tiện ích đã chọn (tuỳ cấu trúc API)
        $picked = collect($post['tien_ich'] ?? [])->pluck('id')->all();

        return view('chutro.edit', compact('post', 'phong', 'tienIch', 'picked'));
    }

    /** 🔄 Cập nhật */
    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'phong_id' => 'required|integer',
            'tieu_de' => 'required|max:255',
            'mo_ta' => 'required|string',
            'gia_niem_yet' => 'required|numeric|min:0',
            'tien_ich' => 'array',
            'anh.*' => 'image|max:5120',
        ]);

        $this->api->setToken(session('api_token'));

        $payload = Arr::only($validated, ['phong_id', 'tieu_de', 'mo_ta', 'gia_niem_yet']);
        $payload['tien_ich'] = $request->input('tien_ich', []);

        try {
            $this->api->post("/bai-dang/{$id}?_method=PUT", $payload); // nếu API không hỗ trợ PUT trực tiếp
        } catch (\Throwable $e) {
            return back()->with('error', 'Cập nhật thất bại: ' . $e->getMessage())->withInput();
        }

        if ($request->hasFile('anh')) {
            try {
                $this->api->postMultipart('/anh-bai-dang/upload', ['bai_dang_id' => $id], [
                    'anh[]' => $request->file('anh'),
                ]);
            } catch (\Throwable $e) {
                Log::error('Upload ảnh thất bại', ['e' => $e->getMessage()]);
            }
        }

        return redirect()->route('chu-tro.bai-dang.index')->with('ok', 'Đã cập nhật bài đăng!');
    }

    /** 🗑️ Xoá */
    public function destroy(int $id)
    {
        $this->api->setToken(session('api_token'));
        try {
            $this->api->post("/bai-dang/{$id}?_method=DELETE");
        } catch (\Throwable $e) {
            return back()->with('error', 'Không thể xoá: ' . $e->getMessage());
        }
        return back()->with('ok', 'Đã xoá bài đăng.');
    }

    /** 🖼️ Upload ảnh (tùy chọn khi dùng riêng) */
    public function upload(Request $request, int $id)
    {
        $request->validate(['anh.*' => 'required|image|max:5120']);
        $this->api->setToken(session('api_token'));

        try {
            // ưu tiên endpoint chuẩn
            $this->api->postMultipart('/anh-bai-dang/upload', ['bai_dang_id' => $id], [
                'anh[]' => $request->file('anh'),
            ]);
        } catch (\Throwable $e) {
            // fallback legacy
            $this->api->postMultipart("/bai-dang/{$id}/anh", [], ['anh[]' => $request->file('anh')]);
        }

        return back()->with('ok', 'Đã upload ảnh.');
    }
}
