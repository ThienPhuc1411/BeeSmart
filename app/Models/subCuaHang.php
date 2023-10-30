<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subCuaHang extends Model
{
    use HasFactory;

    protected $table = 'sub_cua_hang';
    protected $fillable = [
        'idUsers',
        'idCh'
    ];
}
