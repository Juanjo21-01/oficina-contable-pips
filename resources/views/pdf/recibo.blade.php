<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo del Trámite No. {{ $tramite->id }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #1F2937;
        }

        .container {
            width: 600px;
            margin: 0 auto;
            padding: 0px 16px;
            border: 1px solid #D1D5DB;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        .header-table {
            width: 100%;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 3px;
        }

        .header-table td {
            vertical-align: middle;
        }

        .header-table img {
            height: 96px;
            display: block;
            margin: 0 auto;
        }

        .header-table h2 {
            font-size: 24px;
            font-weight: 700;
            margin: 7px 0;
            color: #1f2937;
        }

        .header-table p {
            font-size: 14px;
            margin: 3px 0;
            color: #6c757d;
        }

        .section-title {
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 3px;
            color: #374151;
        }

        .section-content p {
            font-size: 14px;
            margin: 3px 0;
            color: #4b5563;
        }

        .details-table {
            width: 100%;
            font-size: 14px;
            border-collapse: collapse;
        }

        .details-table td {
            padding: 3px 0;
            color: #4b5563;
        }

        .details-table td:last-child {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Encabezado con Logo e Información de la Empresa -->
        <table class="header-table">
            <tr>
                <td style="width: 20%;">
                    <img src="{{ public_path('img/logo.png') }}" alt="Logo de la Empresa">
                </td>
                <td style="text-align: center; width: 80%;">
                    <h2>Recibo de Trámite</h2>
                    <p>Asesoría Fiscal Contable</p>
                    <p>10 calle 7-37, Local #3, Zona 1, San Marcos</p>
                    <p>Teléfono: 5164-4661</p>
                    <p>Fecha: {{ date('d/m/Y') }}</p>
                    <p>Recibo No: #{{ $tramite->id }}</p>
                </td>
            </tr>
        </table>

        <!-- Información del Cliente -->
        <div class="section-content">
            <h3 class="section-title">Información del Cliente</h3>
            <p>Nombre: {{ $tramite->cliente->nombres }} {{ $tramite->cliente->apellidos }}</p>
            <p>Dirección: {{ $tramite->cliente->direccion }}</p>
            <p>Teléfono: {{ $tramite->cliente->telefono }}</p>
            <p>NIT: {{ $tramite->cliente->nit }}</p>
        </div>

        <!-- Detalle de Servicios -->
        <div class="section-content">
            <h3 class="section-title">Detalle del Servicio <span style="font-size: 14px; color: #4b5563;">(Fecha:
                    {{ date('d/m/Y', strtotime($tramite->fecha)) }})</span></h3>
            <table class="details-table">
                <thead>
                    <tr style="border-bottom: 1px solid #E5E7EB;">
                        <th style="text-align: left; padding-bottom: 4px; color: #4b5563;">Descripción</th>
                        <th style="text-align: right; padding-bottom: 4px; color: #4b5563;">Precio</th>
                    </tr>
                </thead>
                <tbody style="color: #4b5563;">
                    <tr>
                        <td style="padding: 4px 0;">{{ $tramite->tipoTramite->nombre }}</td>
                        <td style="text-align: right; padding: 4px 0;">Q. {{ number_format($tramite->precio, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Total -->
        <div style="border-top: 1px solid #e5e7eb; margin-bottom: 6px;">
            <div style="text-align: right; font-weight: 700; color: #DC1B46; font-size: 18px; padding-top: 4px;">
                <span>Total</span>
                <span>Q. {{ number_format($tramite->precio, 2) }}</span>
            </div>
        </div>

        <!-- Firma -->
        <div style="text-align: center; margin-top: 16px;">
            <p style="font-size: 14px; color: #1f2937;">__________________________</p>
            <p style="font-size: 14px; color: #9ca3af;">Firma del Cliente</p>
        </div>
    </div>
</body>

</html>
