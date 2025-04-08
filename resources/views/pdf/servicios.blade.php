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
    </style>
</head>
<body>

<div class="header">
    <div class="title">Reporte de Servicio Técnico</div>
</div>

<div class="section">
    <span class="label">Fecha de reparación:</span> {{ $servicio->fecha_reparacion }}
</div>

<div class="section">
    <span class="label">Tipo de servicio:</span>
    {{ $servicio->tipo_servicio == 0 ? 'Mantenimiento preventivo' : 'Mantenimiento correctivo' }}
</div>

<div class="section">
    <span class="label">Técnico responsable:</span> {{ $servicio->tecnico_responsable }}
</div>

<div class="section">
    <span class="label">Estado final:</span>
    {{ $servicio->estado_final == 0 ? 'Funcional' : 'Devuelto sin funcionar' }}
</div>

<div class="section">
    <span class="label">Garantía:</span> {{ $servicio->garantia == 0 ? 'Sí' : 'No' }}
</div>

<div class="section">
    <span class="label">Repuestos usados:</span>
    <div class="info-box">{{ $servicio->repuestos_usados }}</div>
</div>

<div class="section">
    <span class="label">Tareas realizadas:</span>
    <div class="info-box">{{ $servicio->tareas_realizadas }}</div>
</div>

<div class="section">
    <span class="label">Recomendaciones:</span>
    <div class="highlight">{{ $servicio->recomendaciones }}</div>
</div>

<div class="footer">
    Generado automáticamente por el sistema el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
</div>

</body>
</html>
