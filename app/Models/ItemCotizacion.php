<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCotizacion extends Model
{
    use HasFactory;
    protected $table = 'item_cotizacions';
    protected $fillable = ['repuesto_id', 'cantidad', 'precio_unitario', 'subtotal', 'descripcion'];

    public function repuesto()
    {
        return $this->belongsTo(Repuestos::class); // ojo al nombre de clase
    }
}
