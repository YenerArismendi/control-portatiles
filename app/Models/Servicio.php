<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Servicio extends Model
{
    use HasFactory;

    protected $table = 'servicios';
    protected $fillable = ['id', 'cotizacion_id', 'equipo_type', 'equipo_id', 'tecnico_responsable', 'fallo_reportado', 'diagnostico', 'estado', 'descripcion_servicio', 'garantia', 'recomendaciones', 'total_servicio', 'fecha_reparacion', 'fecha_entrega'];

    public function equipo()
    {
        return $this->morphTo();
    }

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class);
    }

    public function repuestosUtilizados()
    {
        return $this->hasMany(RepuestoUtilizado::class);
    }

}
