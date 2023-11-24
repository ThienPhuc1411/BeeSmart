<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LienHe extends Model
{
    use HasFactory;

    protected $table = 'lien_he';
    protected $fillable = ['ten', 'email', 'sdt', 'diaChi', 'moTa'];
}
