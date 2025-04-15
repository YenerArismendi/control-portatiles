<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipoComputador extends Model
{
    use HasFactory;

    protected $table = 'equipo_computadors';
    protected $fillable = ['id', 'cliente_id', 'marca', 'modelo', 'tipo', 'serie', 'sistema_operativo', 'procesador', 'ram', 'tipo_disco', 'capacidad_disco', 'fallo_reportado', 'fecha_entrega', 'cargador', 'estado', 'diagnostico_tecnico'];

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
