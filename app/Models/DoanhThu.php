<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoanhThu extends Model
{
    use HasFactory;
    protected $table = 'doanh_thu';
    protected $fillable = [
        'ngayTao',
        'doanhThu',
        'loiNhuan',
        'soLuong',
        'hoaDon',
    ];
}
