<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class CuaHang extends Model {
   use HasFactory;
   protected $table='cuahang';
   protected $fillable = ['ten_ch', 'diaChi','Member','idLoaiCh'];
}