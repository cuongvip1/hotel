<?php
namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TenantDashboardController extends Controller
{
    public function index()
    {
        // Lấy thông tin cơ bản
        $khach = DB::table('khach_thue')->first(); // demo: bạn có thể lọc theo auth()->id()
        $phong = DB::table('phong')->where('trang_thai', 'da_thue')->first();

        $tong_hoa_don = DB::table('hoa_don')->count();
        $chua_tt = DB::table('hoa_don')->where('trang_thai', 'chua_thanh_toan')->count();

        return view('khachthue.dashboard', compact('khach', 'phong', 'tong_hoa_don', 'chua_tt'));
    }
}
?>
