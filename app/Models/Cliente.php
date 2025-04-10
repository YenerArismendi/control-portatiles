<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';
    protected $fillable = ['nombre', 'apellido', 'telefono', 'correo'];

    public function equipoComputador()
    {
        return $this->hasMany(EquipoComputador::class);
    }

    public function equipoImpresora()
    {
        return $this->hasMany(EquipoImpresora::class);
    }


}
