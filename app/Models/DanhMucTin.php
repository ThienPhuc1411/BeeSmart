<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DanhMucTin extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='danh_muc_tin';
    protected $fillable = ['ten', 'anHien'];
}
