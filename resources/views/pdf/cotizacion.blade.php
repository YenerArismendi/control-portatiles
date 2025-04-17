<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cotización {{ $cotizacion->numero }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 20px;
        }

        .logo {
            width: 120px; /* Ajusta según el tamaño del logo */
            height: auto; /* Mantener la proporción del logo */
        }

        .company-info {
            text-align: right;
        }

        .company-name {
            font-size: 26px;
            font-weight: bold;
            color: #4CAF50;
            margin: 0;
        }

        .company-contact {
            font-size: 14px;
            color: #555;
            margin-top: 5px;
        }

        .company-contact strong {
            font-weight: bold;
            color: #333;
        }

        .company-contact p {
            margin: 3px 0;
        }

        h2 {
            color: #333;
            text-align: center;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        p {
            color: #555;
            font-size: 14px;
            margin: 5px 0;
        }

        p strong {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            font-size: 14px;
        }

        th {
            background-color: #4CAF50;
            color: #fff;
            font-weight: bold;
        }

        td {
            background-color: #f9f9f9;
        }

        td:nth-child(even) {
            background-color: #f1f1f1;
        }

        tr:hover td {
            background-color: #e8f5e9;
        }

        h3 {
            color: #333;
            font-size: 18px;
            margin-top: 20px;
            font-weight: bold;
        }

        .total {
            color: #4CAF50;
            font-size: 20px;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 30px;
        }

        .footer p {
            margin: 5px 0;
        }

        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="container">
    <table width="100%" style="border: 1px solid #000; border-collapse: collapse; margin-bottom: 20px;">
        <tr>
            <td style="width: 100px; padding: 10px; border-right: 1px solid #000; vertical-align: middle;">
                <img src="{{ public_path('imagen/logo-control-portatiles.jpg') }}" alt="Logo" width="100">
            </td>
            <td style="padding: 10px; vertical-align: middle;">
                <h2 style="margin: 0; color: #4CAF50;">Eky'u</h2>
                <p style="margin: 4px 0;"><strong>Contacto:</strong> julio825_anaya@hotmail.com</p>
                <p style="margin: 4px 0;"><strong>Propietario:</strong> Julio Anaya Rodriguez</p>
                <a href="https://wa.me/573115637752" style="text-decoration: none; color: #4CAF50;" target="_blank">
                    <strong>Telefono:</strong> +57 3115637752
                </a>
            </td>
        </tr>
    </table>

    <h2>Cotización: {{ $cotizacion->numero }}</h2>
    <p><strong>Cliente:</strong> {!! htmlentities($cotizacion->cliente->nombre, ENT_QUOTES, 'UTF-8') !!}</p>
    <p><strong>Marca:</strong>
        @if ($cotizacion->equipo_type === \App\Models\EquipoComputador::class)
            {{ \App\Models\EquipoComputador::find($cotizacion->equipo_id)->marca }}
        @elseif ($cotizacion->equipo_type === \App\Models\EquipoImpresora::class)
            {{ \App\Models\EquipoImpresora::find($cotizacion->equipo_id)->marca }}
        @else
            No asignado
        @endif
    </p>
    <!-- Información del equipo -->
    <p><strong>Modelo:</strong>
        @if ($cotizacion->equipo_type === \App\Models\EquipoComputador::class)
            {{ \App\Models\EquipoComputador::find($cotizacion->equipo_id)->modelo }}
        @elseif ($cotizacion->equipo_type === \App\Models\EquipoImpresora::class)
            {{ \App\Models\EquipoImpresora::find($cotizacion->equipo_id)->modelo }}
        @else
            No asignado
        @endif
    </p>
    <p><strong>Fecha:</strong> {{ $cotizacion->fecha }}</p>
    <p><strong>Fallo
            reportado:</strong> {{ \App\Models\EquipoComputador::find($cotizacion->equipo_id)->fallo_reportado }}</p>
    <p><strong>Diagnóstico:</strong> {!! htmlentities($cotizacion->diagnostico, ENT_QUOTES, 'UTF-8') !!}</p>
    <p><strong>Estado:</strong> {{ $cotizacion->estado }}</p>
    <table>
        <thead>
        <tr>
            <th>Repuesto / Servicio</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
            <th>Descripción</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($cotizacion->items as $item)
            <tr>
                <td><p>{!! htmlentities($item->repuesto->nombre, ENT_QUOTES, 'UTF-8') !!}</p></td>
                <td><p>{{ $item->cantidad }}</p></td>
                <td><p>${{ number_format($item->precio_unitario, 0, ',', '.') }}</p></td>
                <td><p>${{ number_format($item->subtotal, 0, ',', '.') }}</p></td>
                <td><p>{{ $item->descripcion }}</p></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h3>Total: <span class="total">${{ number_format($cotizacion->total, 0, ',', '.') }}</span></h3>
</div>

<div class="footer">
    <p>Si tienes alguna pregunta, por favor contacta con nosotros.</p>
    <p><a href="mailto:julio825_anaya@hotmail.com">julio825_anaya@hotmail.com</a></p>
</div>
</body>
</html>
