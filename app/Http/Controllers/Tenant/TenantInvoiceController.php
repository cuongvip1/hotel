<?php
namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TenantInvoiceController extends Controller
{
    public function index()
    {
        try {
            $invoices = DB::table('hoa_don')
                ->orderByDesc('id')
                ->paginate(10);
        } catch (\Throwable $e) {
            // demo paginator-like array (simple)
            $items = collect([
                (object)[ 'id' => 9001, 'thang' => now()->subMonth()->format('Y-m'), 'tong_tien' => 2000000, 'trang_thai' => 'chua_thanh_toan' ],
                (object)[ 'id' => 9002, 'thang' => now()->format('Y-m'), 'tong_tien' => 2000000, 'trang_thai' => 'da_thanh_toan' ],
            ]);
            // simple LengthAwarePaginator replacement
            $invoices = new \Illuminate\Pagination\LengthAwarePaginator($items, $items->count(), 10, 1, [ 'path' => request()->url() ]);
        }

        return view('khachthue.invoices', compact('invoices'));
    }
}
?>