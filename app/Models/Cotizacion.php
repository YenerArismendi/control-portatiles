<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use function Termwind\renderUsing;

class Cotizacion extends Model
{
    use HasFactory;

    protected $table = 'cotizaciones';
    protected $fillable = ['id', 'cliente_id', 'fecha', 'diagnostico', 'estado', 'total', 'numero'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function items()
    {
        return $this->hasMany(ItemCotizacion::class);
    }

    protected static function booted()
    {
        static::creating(function ($cotizacion) {
            // Si ya viene un número (por alguna razón), no hacer nada
            if (!empty($cotizacion->numero)) return;

            $last = self::orderBy('id', 'desc')->first();
            $nextNumber = $last ? ((int)filter_var($last->numero, FILTER_SANITIZE_NUMBER_INT)) + 1 : 1;
            $cotizacion->numero = 'COT' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        });
    }
}
