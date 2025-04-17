<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CotizacionPdfController extends Controller
{
    public function generarPDF($id)
    {
        $cotizacion = Cotizacion::with(['cliente', 'items.repuesto'])->findOrFail($id);

        // Limpieza básica para evitar errores de codificación
        $cotizacion->diagnostico = mb_convert_encoding($cotizacion->diagnostico, 'UTF-8', 'auto');
        $cotizacion->cliente->nombre = mb_convert_encoding($cotizacion->cliente->nombre, 'UTF-8', 'auto');

        foreach ($cotizacion->items as $item) {
            $item->repuesto->nombre = mb_convert_encoding($item->repuesto->nombre, 'UTF-8', 'auto');
        }

        $pdf = PDF::loadView('pdf.cotizacion', compact('cotizacion'));
        return $pdf->stream("cotizacion_{$cotizacion->numero}.pdf");
    }
}
