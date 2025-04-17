<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repuestos extends Model
{
    use HasFactory;

    protected $table = 'repuestos';
    protected $fillable = ['nombre', 'descripcion', 'precio_sugerido'];

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'repuesto_utilizados')
            ->withPivot('cantidad')
            ->withPivot('precio_unitario')
            ->withPivot('subtotal')
            ->withPivot('descripcion')
            ->withTimestamps();
    }
}
