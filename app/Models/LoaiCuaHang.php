<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiCuaHang extends Model
{
    use HasFactory;
    protected $table='loai_cua_hang';
    protected $fillable = ['ten'];
}
