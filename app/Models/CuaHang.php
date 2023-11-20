<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\LoaiCuaHang;
class CuaHang extends Model {
   use HasFactory;
   protected $table='cua_hang';
   protected $fillable = ['tenCh', 'diaChi','member','idLoaiCh','slug'];

   public function loaiCuaHang(): BelongsTo
   {
      return $this-> belongsTo(LoaiCuaHang::class);
   }
}
