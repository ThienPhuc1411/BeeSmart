<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhMucTin extends Model
{
    use HasFactory;
    protected $table='danh_muc_tin';
    protected $fillable = ['ten', 'anHien'];
}
