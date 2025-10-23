<?php
namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TenantPaymentController extends Controller
{
    public function show($id)
    {
        try {
            $invoice = DB::table('hoa_don')->where('id', $id)->first();
            if (!$invoice) {
                abort(404);
            }
        } catch (\Throwable $e) {
            // demo invoice
            $invoice = (object)[
                'id' => $id,
                'thang' => now()->format('Y-m'),
                'tien_phong' => 2000000,
                'tien_dich_vu' => 0,
                'tien_dong_ho' => 0,
                'tong_tien' => 2000000,
                'trang_thai' => $id == 9002 ? 'da_thanh_toan' : 'chua_thanh_toan',
            ];
        }

        return view('khachthue.payments', compact('invoice'));
    }

    public function pay($id)
    {
        $updated = DB::table('hoa_don')
            ->where('id', $id)
            ->update(['trang_thai' => 'da_thanh_toan']);

        return back()->with($updated ? 'ok' : 'error', $updated ? 'Đã thanh toán thành công!' : 'Không thể thanh toán!');
    }
}
?>