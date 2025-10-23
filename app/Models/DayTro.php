<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayTro extends Model
{
    use HasFactory;

    protected $table = 'day_tro';
    protected $primaryKey = 'id';

    const CREATED_AT = 'ngay_tao';
    const UPDATED_AT = 'ngay_cap_nhat';

    protected $fillable = [
        'chu_tro_id',
        'ten_day_tro',
        'dia_chi',
    ];
}