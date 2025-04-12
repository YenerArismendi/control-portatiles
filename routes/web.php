<?php

use App\Http\Controllers\CotizacionPdfController;
use App\Http\Controllers\ServicioPdfController;
use App\Models\Equipo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/servicio/{servicio}/pdf', [ServicioPdfController::class, 'descargarPDF'])->name('servicio.pdf');

Route::get('/cotizaciones/{id}/pdf', [CotizacionPdfController::class, 'generarPDF'])->name('cotizaciones.pdf');


