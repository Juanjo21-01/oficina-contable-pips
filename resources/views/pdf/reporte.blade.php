<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $nombreArchivo }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #1F2937;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 16px;
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
            margin-bottom: 8px;
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

        .details-table th,
        .details-table td {
            border: 1px solid #D1D5DB;
            padding: 5px;
            color: #4b5563;
        }

        .details-table th {
            text-align: center;
            padding-bottom: 8px;
            color: #4b5563;
        }

        .details-table td {
            font-size: 13px;
        }

        .details-table td:last-child {
            text-align: right;
        }

        .details-table td:last-child {
            text-align: right;
        }

        .card {
            padding: 8px;
            border: 1px solid #D1D5DB;
            border-radius: 8px;
            background-color: #f9fafb;
            text-align: center;
        }

        .card h4 {
            font-size: 14px;
            font-weight: 700;
            margin-top: 0;
            margin-bottom: 4px;
            color: #374151;
        }

        .card p {
            font-size: 14px;
            color: #DC1B46;
        }

        .card-container {
            width: 33%;
            padding: 8px;
        }


        /* No. */
        .details-table th:nth-child(1),
        .details-table td:nth-child(1) {
            width: 5%;
        }

        /* Cliente */
        .details-table th:nth-child(2),
        .details-table td:nth-child(2) {
            width: 20%;
        }

        /* Tipo de Trámite */
        .details-table th:nth-child(3),
        .details-table td:nth-child(3) {
            width: 21%;
        }

        /* Fecha */
        .details-table th:nth-child(4),
        .details-table td:nth-child(4) {
            width: 12%;
        }

        /* Precio */
        .details-table th:nth-child(5),
        .details-table td:nth-child(5) {
            width: 14%;
        }

        /* Gastos */
        .details-table th:nth-child(6),
        .details-table td:nth-child(6) {
            width: 14%;
        }

        /* Total */
        .details-table th:nth-child(7),
        .details-table td:nth-child(7) {
            width: 14%;
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
                    <h2>Reporte de Trámites</h2>
                    <p>Asesoría Fiscal Contable</p>
                    <p>10 calle 7-37, Local #3, Zona 1, San Marcos</p>
                    <p>Teléfono: 5164-4661</p>
                    <p>Fecha: {{ date('d/m/Y') }}</p>
                </td>
            </tr>
        </table>

        <!-- Información del Reporte -->
        <div class="section-content">
            <h3 class="section-title">Resumen del Reporte</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td class="card-container">
                        <div class="card">
                            <h4>Total de Trámites</h4>
                            <p>{{ $totalTramites }}</p>
                        </div>
                    </td>
                    <td class="card-container">
                        <div class="card">
                            <h4>Remanente Total</h4>
                            <p>Q. {{ number_format($gastoTotal, 2) }}</p>
                        </div>
                    </td>
                    <td class="card-container">
                        <div class="card">
                            <h4>Promedio de Remanente</h4>
                            <p>Q. {{ number_format($promedioGasto, 2) }}</p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Tabla de Trámites -->
        <div class="section-content">
            <h3 class="section-title">Detalle de Trámites</h3>
            <table class="details-table">
                <thead>
                    <tr style="border-bottom: 1px solid #E5E7EB;">
                        <th>No.</th>
                        <th>Cliente</th>
                        <th>Tipo de Trámite</th>
                        <th>Fecha</th>
                        <th>Precio</th>
                        <th>Gastos</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tramites as $tramite)
                        <tr>
                            <td style="text-align: center;">{{ $loop->iteration }}</td>
                            <td>{{ $tramite->cliente->nombres }}
                                {{ $tramite->cliente->apellidos }}</td>
                            <td>{{ $tramite->tipoTramite->nombre }}</td>
                            <td>{{ date('d/m/Y', strtotime($tramite->fecha)) }}</td>
                            <td style="text-align: right;">Q. {{ number_format($tramite->precio, 2) }}</td>
                            <td style="text-align: right;">Q. {{ number_format($tramite->gastos, 2) }}</td>
                            <td style="text-align: right;">Q.
                                {{ number_format($tramite->precio - $tramite->gastos, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot style="font-weight: bold">
                    <tr>
                        <td colspan="4" style="text-align: center; width: 58%;">TOTALES</td>
                        <td style="text-align: right; width: 14%;">Q. {{ number_format($totalPrecio, 2) }}</td>
                        <td style="text-align: right; width: 14%;">Q. {{ number_format($totalGastos, 2) }}</td>
                        <td style="text-align: right; width: 14%;">Q. {{ number_format($gastoTotal, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>

</html>
