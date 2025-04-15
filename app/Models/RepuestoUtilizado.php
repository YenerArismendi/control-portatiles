<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepuestoUtilizado extends Model
{
    use HasFactory;
    protected $table = 'repuesto_utilizados';
    protected $fillable = ['id', 'servicio_id', 'repuesto_id', 'cantidad', 'precio_unitario', 'subtotal', 'descripcion'];

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}
