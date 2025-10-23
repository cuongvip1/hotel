<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhachThue extends Model
{
    use HasFactory;

    protected $table = 'khach_thue';
    protected $primaryKey = 'id';

    // Rất quan trọng! Vì cột 'id' này không tự tăng,
    // chúng ta phải báo cho Laravel biết.
    public $incrementing = false;

    const CREATED_AT = 'ngay_tao';
    const UPDATED_AT = 'ngay_cap_nhat';

    protected $fillable = [
        'id',
        'cccd',
        'ngan_sach_min',
        'ngan_sach_max',
    ];

    // Quan hệ: Mỗi KhachThue thuộc về một NguoiDung.
    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'id', 'id');
    }

    // Quan hệ: Mỗi KhachThue có nhiều HopDong
    public function hopDong()
    {
        return $this->hasMany(HopDong::class, 'khach_thue_id', 'id');
    }
}