<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipoImpresora extends Model
{
    use HasFactory;

    protected $table = 'equipo_impresoras';
    protected $fillable = ['id', 'cliente_id', 'marca', 'modelo', 'tipo', 'serie', 'fallo_reportado', 'estado', 'fecha_entrega', 'cargador'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
