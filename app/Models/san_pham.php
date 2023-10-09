<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class san_pham extends Model
{
    use HasFactory;
    protected $table = 'san_pham';
    protected $fillable=[
        'ten',
        'img',
        'giaVon',
        'giaBan',
        'khuyenMai',
        'donVi',
        'soLuong',
        'khoiLuong',
        'theTich',
        'idCh',
        'idNcc',
        'idTh',
        'idDm',
        'idLoai',
        'maSp',
        'ngayTao'


    ];
}
