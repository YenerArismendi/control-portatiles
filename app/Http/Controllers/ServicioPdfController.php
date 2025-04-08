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

        // Aquí generas tu PDF con DomPDF, Snappy, etc.
        $pdf = PDF::loadView('pdf.servicios', compact('servicio'));

        return $pdf->download("Servicio_{$servicio->id}.pdf");
    }
}
