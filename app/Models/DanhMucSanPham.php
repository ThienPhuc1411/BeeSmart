<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\sanPham;

class DanhMucSanPham extends Model
{
    use HasFactory;
    protected $table = 'dm_san_pham';
    protected $fillable = ['ten', 'idCh'];

    function sanPham() {
        return $this->hasMany(sanPham::class, 'idDm', 'id');
    }
}
