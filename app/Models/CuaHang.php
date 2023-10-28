<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class CuaHang extends Model {
   use HasFactory;
   protected $table='cua_hang';
   protected $fillable = ['tenCh', 'diaChi','member','idLoaiCh','slug'];
}
