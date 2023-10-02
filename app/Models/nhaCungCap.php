<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nhaCungCap extends Model
{
    use HasFactory;
    protected $table = "nha_cung_cap";
    protected $primary_key = "id";
    protected $fillable = [
        'ten',
        'diaChi',
        'email',
        'sdt',
        'MST'
    ];
}
