<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipoImpresora extends Model
{
    use HasFactory;

    protected $table = 'equipo_impresoras';
    protected $fillable = ['id', 'cliente_id', 'marca', 'modelo', 'tipo', 'serie', 'fallo_reportado', 'estado', 'fecha_entrega', 'cargador', 'diagnostico_tecnico'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function servicio()
    {
        return $this->morphMany(Servicio::class, 'equipo');
    }


    public function cotizaciones()
    {
        return $this->morphMany(Cotizacion::class, 'equipo');
    }
}
