<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte de Servicio Técnico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 40px;
        }

        .header {
            border-bottom: 2px solid #444;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header .title {
            font-size: 22px;
            font-weight: bold;
            text-align: center;
            color: #1a1a1a;
        }

        .section {
            margin-bottom: 15px;
        }

        .label {
            font-weight: bold;
            width: 180px;
            display: inline-block;
        }

        .info-box {
            border: 1px solid #ccc;
            padding: 10px 15px;
            border-radius: 6px;
            background: #f9f9f9;
            margin-top: 5px;
        }

        .footer {
            margin-top: 40px;
            font-size: 11px;
            text-align: center;
            color: #888;
        }

        .highlight {
            background-color: #efefef;
            padding: 8px;
            border-left: 4px solid #007BFF;
            margin-top: 10px;
        }

        /*Estilo para tabla*/
        .table-repuestos {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-top: 15px;
            color: #333;
        }

        .table-repuestos thead {
            background-color: #e2e8f0;
        }

        .table-repuestos th,
        .table-repuestos td {
            border: 1px solid #cbd5e0;
            padding: 8px 12px;
            text-align: left;
            vertical-align: middle;
        }

        .table-repuestos th {
            font-weight: 600;
            font-size: 13px;
            background-color: #edf2f7;
        }

        .table-repuestos tbody tr:nth-child(even) {
            background-color: #f7fafc;
        }

        .table-repuestos tbody tr:hover {
            background-color: #e2e8f0;
        }

        .titulo-tabla {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #2d3748;
            border-bottom: 2px solid #cbd5e0;
            padding-bottom: 4px;
        }
    </style>
</head>
<body>
<table width="100%" style="border: 1px solid #ccc; border-collapse: collapse; font-family: sans-serif;">
    <tr>
        <!-- Logo -->
        <td style="width: 120px; border-right: 1px solid #ccc; text-align: center; background-color: #fff; padding: 10px;">
            <img src="{{ public_path('imagen/logo-control-portatiles.jpg') }}" alt="Logo" width="100">
        </td>

        <!-- Información -->
        <td style="background-color: #f3f3f3; padding: 10px;">
            <!-- Título -->
            <h2 style="margin: 0; color: #4CAF50; text-align: center;">Eky'u</h2>

            <!-- Línea verde -->
            <hr style="border: none; border-top: 2px solid #4CAF50; margin: 5px 0;">

            <!-- Detalles -->
            <p style="margin: 5px 0;">
                <strong>Contacto:</strong> julio825_anaya@hotmail.com
            </p>
            <p style="margin: 5px 0;">
                <strong>Propietario:</strong> Julio Anaya Rodriguez
            </p>
            <p style="margin: 5px 0; color: #4CAF50;">
                <strong>Teléfono:</strong> +57 3115637752
            </p>
        </td>
    </tr>
</table>
<br>

<div class="header">
    <div class="title">Reporte de Servicio Técnico</div>
</div>

<div class="section">
    <span class="label">Marca y modelo:</span> {{ $servicio->equipo->marca . ' ' . $servicio->equipo->modelo }}
</div>
<div class="section">
    <span class="label">Técnico responsable:</span> {{ $servicio->tecnico_responsable }}
</div>
<div class="section">
    <span class="label">Fallo reportado:</span> {{ $servicio->fallo_reportado }}
</div>
<div class="section">
    <span class="label">Diagnóstico:</span> {{ $servicio->diagnostico }}
</div>
<div class="section">
    <span class="label">Estado final del equipo:</span>
    {{ $servicio->estado == 0 ? 'Funcional' : 'Devuelto sin funcionar' }}
</div>
<div class="section">
    <span class="label">Servicio realizado:</span> {{ $servicio->descripcion_servicio }}
</div>
<div class="section">
    <span class="label">Garantía:</span> {{ $servicio->garantia == 0 ? 'Sí' : 'No' }}
</div>
{{--@dd($servicio)--}}
<div class="section">
    <span class="label">Fecha de reparación:</span> {{ $servicio->fecha_reparacion }}
</div>
<div class="section">
    <span class="label">Fecha de entrega:</span> {{ $servicio->fecha_entrega }}
</div>
<h3 class="titulo-tabla">Repuestos Usados</h3>

<table class="table-repuestos">
    <thead>
    <tr>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Cantidad</th>
        <th>Precio unitario</th>
        <th>Subtotal</th>
    </tr>
    </thead>
    <tbody>
    @foreach($servicio->repuestos as $repuesto)
        <tr>
            <td>{{ $repuesto->nombre }}</td>
            <td>{{ $repuesto->pivot->descripcion }}</td>
            <td>{{ $repuesto->pivot->cantidad }}</td>
            <td>${{ number_format($repuesto->pivot->precio_unitario, 0, ',', '.') }}</td>
            <td>${{ number_format($repuesto->pivot->subtotal, 0, ',', '.') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<h3 class="titulo-tabla">Total: ${{ number_format($servicio->total_servicio, 0, ',', '.') }}</h3>

<div class="section">
    <span class="label">Recomendaciones:</span>
    <div class="highlight">{{ $servicio->recomendaciones }}</div>
</div>

<div class="footer">
    @if($servicio->garantia == 0)
        <p>La duración de la garantía es de 60 días.</p>
    @endif
    <p>Generado automáticamente por el sistema el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
</div>

</body>
</html>
