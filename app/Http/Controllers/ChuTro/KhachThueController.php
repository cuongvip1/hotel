<?php
namespace App\Http\Controllers\ChuTro;

use App\Http\Controllers\Controller;
use App\Models\KhachThue; // <--- THÊM DÒNG NÀY
use App\Models\NguoiDung;   // Thêm sẵn để dùng cho các hàm khác
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;     // Thêm sẵn
use Illuminate\Support\Facades\Hash;  // Thêm sẵn
use Illuminate\Support\Facades\Auth;

class KhachThueController extends Controller
{
    // --- INDEX: Hiển thị danh sách ---
    public function index(Request $request)
    {
        $chuTro = Auth::user();

        if (!$chuTro) {

            return redirect()->route('login')->with('error', 'Phiên đăng nhập không hợp lệ.');
        }

        // Bắt đầu câu truy vấn
        $query = KhachThue::query()->with('nguoiDung')
            ->whereHas('hopDong.phong.dayTro', function ($q) use ($chuTro) {
                $q->where('chu_tro_id', $chuTro->id);
            });

        // Xử lý tìm kiếm
        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->whereHas('nguoiDung', function ($q) use ($keyword) {
                $q->where('ho_ten', 'like', "%{$keyword}%")
                    ->orWhere('so_dien_thoai', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        // Lấy dữ liệu và phân trang
        $khachThue = $query->latest()->paginate(10);

        // Trả về view cùng với dữ liệu
        return view('chu-tro.khach-thue.index', ['khachThue' => $khachThue]);
    }

    // --- CREATE: Hiển thị form tạo mới ---
    public function create()
    {
        return view('chu-tro.khach-thue.create');
    }

    // --- STORE: Lưu dữ liệu từ form tạo mới ---
    public function store(Request $request)
    {
        // Validate dữ liệu
        $validated = $request->validate([
            'ho_ten' => 'required|string|max:255',
            'so_dien_thoai' => 'required|string|max:20|unique:nguoi_dung,so_dien_thoai',
            'email' => 'required|email|max:255|unique:nguoi_dung,email',
            'mat_khau' => 'required|string|min:6',
            'cccd' => 'required|string|max:20|unique:khach_thue,cccd',
        ]);

        DB::beginTransaction();
        try {
            $nguoiDung = NguoiDung::create([
                'ho_ten' => $validated['ho_ten'],
                'so_dien_thoai' => $validated['so_dien_thoai'],
                'email' => $validated['email'],
                'mat_khau' => Hash::make($validated['mat_khau']),
                'vai_tro' => 'khach_thue',
                'trang_thai' => 'hoat_dong',
                'anh_dai_dien' => 'default.png'
            ]);

            KhachThue::create([
                'id' => $nguoiDung->id,
                'cccd' => $validated['cccd'],
            ]);

            DB::commit();
            return redirect()->route('chu-tro.khach-thue.index')->with('success', 'Thêm khách thuê thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Đã có lỗi xảy ra: ' . $e->getMessage())->withInput();
        }
    }


    // --- DESTROY: Xóa khách thuê ---
    public function destroy($id)
    {
        $khachThue = KhachThue::findOrFail($id);

        if ($khachThue->hopDong()->where('trang_thai', 'hieu_luc')->exists()) {
            return back()->with('error', 'Không thể xóa khách thuê đang có hợp đồng hiệu lực.');
        }

        // Xóa người dùng, khách thuê sẽ tự xóa theo (ON DELETE CASCADE)
        $khachThue->nguoiDung()->delete();

        return redirect()->route('chu-tro.khach-thue.index')->with('success', 'Xóa khách thuê thành công!');
    }

    // Các hàm edit, update sẽ làm tương tự
}