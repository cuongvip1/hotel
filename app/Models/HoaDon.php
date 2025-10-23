<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HoaDon extends Model
{
    protected $table = 'hoa_don'; // khớp với DB của bạn
    protected $fillable = [
        'hop_dong_id','thang','tien_phong','tien_dich_vu','tien_dong_ho',
        'tong_tien','trang_thai','ngay_tao','han_thanh_toan'
    ];

    public function hdong(): BelongsTo {
        return $this->belongsTo(HopDong::class, 'hop_dong_id');
    }

    public function tt(): HasMany {
        return $this->hasMany(Payment::class, 'hoa_don_id');
    }
}
