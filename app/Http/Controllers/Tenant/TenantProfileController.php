<?php
namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TenantProfileController extends Controller
{
    public function edit()
    {
        $profile = DB::table('khach_thue')->first();
        return view('khachthue.profile', compact('profile'));
    }

    public function update(Request $r)
    {
        $r->validate([
            'cccd' => 'required',
            'ngan_sach_min' => 'required|numeric',
            'ngan_sach_max' => 'required|numeric'
        ]);

        DB::table('khach_thue')->where('id', $r->id)->update([
            'cccd' => $r->cccd,
            'ngan_sach_min' => $r->ngan_sach_min,
            'ngan_sach_max' => $r->ngan_sach_max,
            'ngay_cap_nhat' => now(),
        ]);

        return back()->with('ok', 'Đã cập nhật hồ sơ!');
    }
}
?>
