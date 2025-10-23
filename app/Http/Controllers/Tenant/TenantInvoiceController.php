<?php
namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TenantInvoiceController extends Controller
{
    public function index()
    {
        $invoices = DB::table('hoa_don')
            ->orderByDesc('id')
            ->paginate(10);

        return view('khachthue.invoices', compact('invoices'));
    }
}
?>