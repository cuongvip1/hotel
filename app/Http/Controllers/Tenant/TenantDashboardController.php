<?php
namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TenantDashboardController extends Controller
{
    public function index()
    {
        // Thử lấy từ DB; nếu có lỗi (không có DB) thì dùng dữ liệu demo để UI vẫn chạy
        try {
            $khach = DB::table('khach_thue')->first(); // demo: bạn có thể lọc theo auth()->id()
            $phong = DB::table('phong')->where('trang_thai', 'da_thue')->first();

            $tong_hoa_don = DB::table('hoa_don')->count();
            $chua_tt = DB::table('hoa_don')->where('trang_thai', 'chua_thanh_toan')->count();
        } catch (\Throwable $e) {
            // Fallback demo data
            $khach = (object)[
                'id' => 1000,
                'cccd' => '123456789',
            ];
            $phong = (object)[
                'so_phong' => 'A101',
            ];
            $tong_hoa_don = 2;
            $chua_tt = 1;
        }

        return view('khachthue.dashboard', compact('khach', 'phong', 'tong_hoa_don', 'chua_tt'));
    }
}
?>
