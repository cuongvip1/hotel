<?php
namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TenantPaymentController extends Controller
{
    public function show($id)
    {
        $invoice = DB::table('hoa_don')->where('id', $id)->first();
        abort_unless($invoice, 404);

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