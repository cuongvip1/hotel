<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phong extends Model
{
    use HasFactory;

    protected $table = 'phong';
    protected $primaryKey = 'id';

    const CREATED_AT = 'ngay_tao';
    const UPDATED_AT = 'ngay_cap_nhat';

    protected $fillable = [
        'day_tro_id',
        'so_phong',
        'gia',
        'trang_thai',
        'suc_chua',
        'dien_tich',
        'tang',
    ];

    // Quan hệ: Mỗi phòng thuộc về một Dãy Trọ
    public function dayTro()
    {
        // Chú ý: Bạn cũng sẽ cần tạo model DayTro.php
        return $this->belongsTo(DayTro::class, 'day_tro_id', 'id');
    }
}