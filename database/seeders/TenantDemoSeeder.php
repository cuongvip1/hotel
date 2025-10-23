<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TenantDemoSeeder extends Seeder
{
    public function run()
    {
        // Tạo người dùng (nguoi_dung) giả
        DB::table('nguoi_dung')->insert([
            'id' => 1000,
            'ho_ten' => 'Demo Khach Thue',
            'so_dien_thoai' => '0123456789',
            'email' => 'tenant@example.test',
            'mat_khau' => Hash::make('password'),
            'vai_tro' => 'khach_thue',
            'trang_thai' => 'hoat_dong',
            'anh_dai_dien' => 'default.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tạo bản ghi khach_thue (bảng khach_thue)
        DB::table('khach_thue')->insert([
            'id' => 1000,
            'cccd' => '123456789',
            'ngan_sach_min' => 0,
            'ngan_sach_max' => 1000000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tạo 1 day_tro + 1 phong liên kết với demo chủ trọ (giả dùng chu_tro_id = 1)
        $dayId = DB::table('day_tro')->insertGetId([
            'ten' => 'Dãy demo',
            'dia_chi' => 'Demo Address',
            'chu_tro_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $phongId = DB::table('phong')->insertGetId([
            'so_phong' => 'A101',
            'day_tro_id' => $dayId,
            'trang_thai' => 'da_thue',
            'gia' => 2000000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tạo hợp đồng liên kết khach_thue - phong
        DB::table('hop_dong')->insert([
            'id' => 5000,
            'khach_thue_id' => 1000,
            'phong_id' => $phongId,
            'ngay_bat_dau' => now()->subMonths(2),
            'ngay_ket_thuc' => now()->addMonths(10),
            'trang_thai' => 'hieu_luc',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tạo 2 hoa_don cho khách thuê
        DB::table('hoa_don')->insert([
            [
                'id' => 9001,
                'khach_thue_id' => 1000,
                'thang' => now()->subMonth()->format('Y-m'),
                'tien_phong' => 2000000,
                'tien_dich_vu' => 0,
                'tien_dong_ho' => 0,
                'tong_tien' => 2000000,
                'trang_thai' => 'chua_thanh_toan',
                'created_at' => now()->subMonth(),
                'updated_at' => now()->subMonth(),
            ],
            [
                'id' => 9002,
                'khach_thue_id' => 1000,
                'thang' => now()->format('Y-m'),
                'tien_phong' => 2000000,
                'tien_dich_vu' => 0,
                'tien_dong_ho' => 0,
                'tong_tien' => 2000000,
                'trang_thai' => 'da_thanh_toan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
