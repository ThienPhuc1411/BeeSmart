<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\HoaDon;

class HoaDonCT extends Model
{
    use HasFactory;

    protected $table = 'hoa_don_chi_tiet_bh';

    protected $fillable = ['idHd', 'idSp', 'soLuong', 'tong'];

    public function hoaDon() {
        return $this->belongsTo(HoaDon::class, 'idHd', 'id');
    }
}
