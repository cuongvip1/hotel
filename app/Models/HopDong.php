<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HopDong extends Model
{
    use HasFactory;

    protected $table = 'hop_dong';
    protected $primaryKey = 'id';

    const CREATED_AT = 'ngay_tao';
    const UPDATED_AT = 'ngay_cap_nhat';

    protected $fillable = [
        'khach_thue_id',
        'phong_id',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'tien_coc',
        'trang_thai',
        'url_file_hop_dong',
    ];

    // Thêm các quan hệ nếu cần
    public function khachThue()
    {
        return $this->belongsTo(KhachThue::class, 'khach_thue_id', 'id');
    }

    public function phong()
    {
        // Chú ý: Bạn cũng sẽ cần tạo model Phong.php
        return $this->belongsTo(Phong::class, 'phong_id', 'id');
    }
}