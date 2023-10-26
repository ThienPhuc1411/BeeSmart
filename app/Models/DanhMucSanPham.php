<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\san_pham;

class DanhMucSanPham extends Model
{
    use HasFactory;
    protected $table = 'dm_san_pham';
    protected $fillable = ['ten', 'idCh'];

    function sanPham() {
        return $this->hasMany(san_pham::class, 'idDm', 'id');
    }
}
