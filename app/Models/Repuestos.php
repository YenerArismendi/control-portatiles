<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repuestos extends Model
{
    use HasFactory;
    protected $table = 'repuestos';
    protected $fillable = ['nombre', 'descripcion', 'precio_sugerido'];
}
