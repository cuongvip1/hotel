<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $table = 'payments';
    protected $fillable = [
        'hoa_don_id','kt_id','so_tien','pt_tt','trang_thai','evi','ghichu','pay_at'
    ];

    public function hdon(): BelongsTo { return $this->belongsTo(HoaDon::class, 'hoa_don_id'); }
    public function kt(): BelongsTo   { return $this->belongsTo(KhachThue::class, 'kt_id'); }
}
