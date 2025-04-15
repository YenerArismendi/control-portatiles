<?php

namespace App\Observers;

use App\Models\Cotizacion;
use App\Models\Servicio;
use Filament\Facades\Filament;

class CotizacionObserver
{
    /**
     * Handle the Cotizacion "created" event.
     */
    public function created(Cotizacion $cotizacion): void
    {
        //
    }

    /**
     * Handle the Cotizacion "updated" event.
     */
    public function updated(Cotizacion $cotizacion): void
    {
        if ($cotizacion->isDirty('estado') && $cotizacion->estado === 'aceptada') {
            Servicio::create([
                'cotizacion_id' => $cotizacion->id,
                'equipo_type' => $cotizacion->equipo_type,
                'equipo_id' => $cotizacion->equipo_id,
                'fallo_reportado' => $cotizacion->equipo?->fallo_reportado,
                'diagnostico' => $cotizacion->equipo?->diagnostico_tecnico,
                'total_servicio' => $cotizacion->total,
            ]);
            session()->flash('servicio_creado', 'El servicio fue creado correctamente.');
        }
    }

    /**
     * Handle the Cotizacion "deleted" event.
     */
    public function deleted(Cotizacion $cotizacion): void
    {
        //
    }

    /**
     * Handle the Cotizacion "restored" event.
     */
    public function restored(Cotizacion $cotizacion): void
    {
        //
    }

    /**
     * Handle the Cotizacion "force deleted" event.
     */
    public function forceDeleted(Cotizacion $cotizacion): void
    {
        //
    }
}
