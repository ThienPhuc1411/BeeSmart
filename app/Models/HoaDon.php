<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CuaHang;
use App\Models\HoaDonCT;

class HoaDon extends Model
{
    use HasFactory;

    protected $table = 'hoa_don_ban_hang';
    protected $fillable = ['tongTien', 'idCh', 'maHd', 'tongGiamGia'];

    public function cuaHang() {
        return $this->belongsTo(CuaHang::class, 'idCh', 'id');
    }

    public function hoaDonCT() {
        return $this->hasMany(HoaDonCT::class, 'idHd', 'id');
    }
}
