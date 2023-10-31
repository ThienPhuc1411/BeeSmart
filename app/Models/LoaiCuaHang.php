<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoaiCuaHang extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='loai_cua_hang';
    protected $fillable = ['ten'];
}
