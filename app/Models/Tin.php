<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tin extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='tin_tuc';
    protected $fillable = ['tieuDe','tomTat','noiDung','view','idDmTin','idUsers', 'anHien','urlHinh'];
}
