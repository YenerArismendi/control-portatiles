<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Servicio extends Model
{
    use HasFactory;

    protected $table = 'servicios';
    protected $fillable = ['equipo_id', 'fecha_reparacion', 'tipo_servicio', 'tareas_realizadas', 'tecnico_responsable', 'repuestos_usados', 'estado_final', 'garantia', 'recomendaciones'];

    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class);
    }
}
