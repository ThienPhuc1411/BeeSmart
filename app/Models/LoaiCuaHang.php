<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\CuaHang;

class LoaiCuaHang extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='loai_cua_hang';
    protected $fillable = ['ten'];

    public function cuaHang():HasMany
    {
        return $this->hasMany( CuaHang::class ,'idLoaiCh','id');
    }
}
