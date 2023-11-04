<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BinhLuan extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "binh_luan";
    protected $fillable = [
        'idTin',
        'ngayDang',
        'noiDung',
        'email',
        'hoTen'
    ] ;
}
