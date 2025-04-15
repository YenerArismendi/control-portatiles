<?php

namespace App\Observers;

use App\Models\Servicio;
use App\Models\RepuestoUtilizado;

class ServicioObserver
{
    /**
     * Handle the Servicio "created" event.
     */
    public function created(Servicio $servicio): void
    {
        // Obtenemos la cotización relacionada
        $cotizacion = $servicio->cotizacion;

        // Copiamos los items de la cotización a los repuestos utilizados
        foreach ($cotizacion->items as $item) {
            $servicio->repuestosUtilizados()->create([
                'repuesto_id' => $item->repuesto_id,
                'cantidad' => $item->cantidad,
                'precio_unitario' => $item->precio_unitario,
                'subtotal' => $item->subtotal,
                'descripcion' => $item->descripcion,
            ]);
        }
    }

    /**
     * Handle the Servicio "updated" event.
     */
    public function updated(Servicio $servicio): void
    {
        //
    }

    /**
     * Handle the Servicio "deleted" event.
     */
    public function deleted(Servicio $servicio): void
    {
        //
    }

    /**
     * Handle the Servicio "restored" event.
     */
    public function restored(Servicio $servicio): void
    {
        //
    }

    /**
     * Handle the Servicio "force deleted" event.
     */
    public function forceDeleted(Servicio $servicio): void
    {
        //
    }
}
