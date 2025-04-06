<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipo extends Model
{
    use HasFactory;
    protected $table = 'equipos';
    protected $fillable = ['cliente_id', 'marca', 'tipo_equipo', 'modelo', 'procesador', 'ram', 'almacenamiento', 'sistema_operativo', 'cargador', 'entregado', 'detalles'];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function servicios(): HasMany
    {
        return $this->hasMany(Servicio::class);
    }
}
