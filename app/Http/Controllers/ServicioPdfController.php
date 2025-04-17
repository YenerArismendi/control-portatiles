<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ServicioPdfController extends Controller
{
    public function descargarPDF($id)
    {
        $servicio = Servicio::with('equipo')->findOrFail($id);

        $pdf = PDF::loadView('pdf.servicios', [
            'servicio' => $servicio,
            'equipo' => $servicio->equipo
        ]);

        return $pdf->download("Servicio_{$servicio->id}.pdf");
    }
}
