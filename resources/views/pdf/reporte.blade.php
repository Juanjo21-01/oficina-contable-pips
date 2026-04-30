<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $nombreArchivo }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 1.2cm 2.0cm 2.0cm 2.0cm;
        }
        footer {
            position: fixed;
            bottom: -1.6cm;
            left: 0;
            right: 0;
            height: 1.4cm;
            border-top: 1px solid #e2e8f0;
            padding-top: 4px;
            font-size: 9px;
            color: #94a3b8;
            font-family: Arial, Helvetica, sans-serif;
        }
        .pagenum:before { content: "Página " counter(page) " de " counter(pages); }

        html, body {
            margin: 0;
            padding: 0;
            padding-top: 8px;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #0f172a;
            background: #fff;
        }
        .mono { font-family: "Courier New", Courier, monospace; }
    </style>
</head>
<body>

<footer>
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="text-align:left;">Oficina Contable "Méndez García &amp; Asociados"</td>
            <td style="text-align:center;">Generado el {{ date('d/m/Y') }} a las {{ date('H:i') }}</td>
            <td style="text-align:right;"><span class="pagenum"></span></td>
        </tr>
    </table>
</footer>

{{-- ═══ ENCABEZADO ═══
     Col logo: 110px | Col empresa: auto | Col meta: 270px
--}}
<table width="100%" cellpadding="0" cellspacing="0"
       style="border-collapse:collapse; border-bottom:3px solid #4f46e5;">
    <tr>
        <td style="width:110px; vertical-align:middle; padding:0 10px 10px 0;">
            <img src="{{ public_path('img/logo.png') }}" alt="Logo" style="height:60px; display:block;">
        </td>
        <td style="vertical-align:middle; text-align:center; padding:0 10px 10px;">
            <div style="font-size:15px; font-weight:700; color:#312e81; margin-bottom:3px;">
                Méndez García &amp; Asociados
            </div>
            <div style="font-size:10px; color:#64748b; margin:2px 0;">Oficina Contable Autorizada</div>
            <div style="font-size:10px; color:#64748b; margin:2px 0;">10 7ª Avenida 3-40, Zona 2, San Pedro Sacatepéquez, San Marcos</div>
            <div style="font-size:10px; color:#64748b; margin:2px 0;">Tel: 5861-2987 &nbsp;|&nbsp; 5611-6232</div>
        </td>
        <td style="width:270px; vertical-align:top; padding:0 0 10px 10px;">
            <div style="background:#4f46e5; color:#fff; font-size:11px; font-weight:700;
                        padding:5px 8px; border-radius:4px; margin-bottom:6px; text-align:center;">
                REPORTE DE TRÁMITES
            </div>
            <table width="270" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                <tr>
                    <td style="width:120px; font-size:10px; color:#64748b; padding:2px 0;">Archivo:</td>
                    <td style="width:150px; font-size:10px; font-weight:600; text-align:right; padding:2px 0;">
                        {{ $nombreArchivo }}
                    </td>
                </tr>
                <tr>
                    <td style="font-size:10px; color:#64748b; padding:2px 0;">Fecha generación:</td>
                    <td style="font-size:10px; font-weight:600; text-align:right; padding:2px 0;">{{ date('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <td style="font-size:10px; color:#64748b; padding:2px 0;">Total trámites:</td>
                    <td style="font-size:10px; font-weight:600; text-align:right; padding:2px 0;" class="mono">{{ $totalTramites }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

{{-- ═══ KPIs ═══
     5 celdas width:20% dentro tabla 100% — nunca desborda
--}}
<div style="font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.07em;
            color:#4f46e5; border-bottom:1px solid #e0e7ff; padding-bottom:3px;
            margin-top:10px; margin-bottom:6px;">
    Resumen del Período
</div>
<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
    <tr>
        <td style="width:20%; vertical-align:top; padding-right:4px;">
            <div style="border:1px solid #e0e7ff; border-top:3px solid #4f46e5;
                        border-radius:4px; padding:8px 6px; background:#f8fafc; text-align:center;">
                <div style="font-size:9px; text-transform:uppercase; letter-spacing:0.05em; color:#64748b; font-weight:700; margin-bottom:4px;">Total Trámites</div>
                <div style="font-size:15px; font-weight:700; color:#4338ca;">{{ $totalTramites }}</div>
            </div>
        </td>
        <td style="width:20%; vertical-align:top; padding-right:4px;">
            <div style="border:1px solid #e0e7ff; border-top:3px solid #4f46e5;
                        border-radius:4px; padding:8px 6px; background:#f8fafc; text-align:center;">
                <div style="font-size:9px; text-transform:uppercase; letter-spacing:0.05em; color:#64748b; font-weight:700; margin-bottom:4px;">Ingresos Brutos</div>
                <div style="font-size:15px; font-weight:700; color:#4338ca; font-family:'Courier New',Courier,monospace;">Q.&nbsp;{{ number_format($totalPrecio, 2) }}</div>
            </div>
        </td>
        <td style="width:20%; vertical-align:top; padding-right:4px;">
            <div style="border:1px solid #e0e7ff; border-top:3px solid #4f46e5;
                        border-radius:4px; padding:8px 6px; background:#f8fafc; text-align:center;">
                <div style="font-size:9px; text-transform:uppercase; letter-spacing:0.05em; color:#64748b; font-weight:700; margin-bottom:4px;">Gastos Totales</div>
                <div style="font-size:15px; font-weight:700; color:#4338ca; font-family:'Courier New',Courier,monospace;">Q.&nbsp;{{ number_format($totalGastos, 2) }}</div>
            </div>
        </td>
        <td style="width:20%; vertical-align:top; padding-right:4px;">
            <div style="border:1px solid #ccfbf1; border-top:3px solid #14b8a6;
                        border-radius:4px; padding:8px 6px; background:#f8fafc; text-align:center;">
                <div style="font-size:9px; text-transform:uppercase; letter-spacing:0.05em; color:#64748b; font-weight:700; margin-bottom:4px;">Remanente Total</div>
                <div style="font-size:15px; font-weight:700; color:#0f766e; font-family:'Courier New',Courier,monospace;">Q.&nbsp;{{ number_format($gastoTotal, 2) }}</div>
            </div>
        </td>
        <td style="width:20%; vertical-align:top;">
            <div style="border:1px solid #ccfbf1; border-top:3px solid #14b8a6;
                        border-radius:4px; padding:8px 6px; background:#f8fafc; text-align:center;">
                <div style="font-size:9px; text-transform:uppercase; letter-spacing:0.05em; color:#64748b; font-weight:700; margin-bottom:4px;">Promedio Remanente</div>
                <div style="font-size:15px; font-weight:700; color:#0f766e; font-family:'Courier New',Courier,monospace;">Q.&nbsp;{{ number_format($promedioGasto, 2) }}</div>
            </div>
        </td>
    </tr>
</table>

{{-- ═══ TABLA DETALLE ═══
     Col 1: 36px | Col 2,3: auto | Col 4: 90px | Col 5,6: 110px | Col 7: 120px
--}}
<div style="font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.07em;
            color:#4f46e5; border-bottom:1px solid #e0e7ff; padding-bottom:3px;
            margin-top:12px; margin-bottom:0;">
    Detalle de Trámites
</div>
<table width="100%" cellpadding="0" cellspacing="0"
       style="border-collapse:collapse; table-layout:fixed; font-size:11px;">
    <colgroup>
        <col style="width:36px;">
        <col>
        <col>
        <col style="width:90px;">
        <col style="width:110px;">
        <col style="width:110px;">
        <col style="width:120px;">
    </colgroup>
    <thead>
        <tr style="background:#4f46e5;">
            <th style="color:#fff; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; padding:6px 5px; text-align:center;">No.</th>
            <th style="color:#fff; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; padding:6px 5px; text-align:left;">Cliente</th>
            <th style="color:#fff; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; padding:6px 5px; text-align:left;">Tipo de Trámite</th>
            <th style="color:#fff; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; padding:6px 5px; text-align:center;">Fecha</th>
            <th style="color:#fff; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; padding:6px 5px; text-align:right;">Precio</th>
            <th style="color:#fff; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; padding:6px 5px; text-align:right;">Gastos</th>
            <th style="color:#fff; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; padding:6px 5px; text-align:right;">Remanente</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tramites as $tramite)
        <tr style="background:{{ $loop->even ? '#f8fafc' : '#fff' }};">
            <td style="padding:5px 5px; border-bottom:1px solid #e2e8f0; text-align:center; color:#1e293b; font-family:'Courier New',Courier,monospace;">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
            <td style="padding:5px 5px; border-bottom:1px solid #e2e8f0; color:#1e293b; overflow:hidden;">{{ $tramite->cliente->nombres }} {{ $tramite->cliente->apellidos }}</td>
            <td style="padding:5px 5px; border-bottom:1px solid #e2e8f0; color:#1e293b; overflow:hidden;">{{ $tramite->tipoTramite->nombre }}</td>
            <td style="padding:5px 5px; border-bottom:1px solid #e2e8f0; text-align:center; color:#1e293b;">{{ date('d/m/Y', strtotime($tramite->fecha)) }}</td>
            <td style="padding:5px 5px; border-bottom:1px solid #e2e8f0; text-align:right; color:#1e293b; font-family:'Courier New',Courier,monospace;">Q.&nbsp;{{ number_format($tramite->precio, 2) }}</td>
            <td style="padding:5px 5px; border-bottom:1px solid #e2e8f0; text-align:right; color:#1e293b; font-family:'Courier New',Courier,monospace;">Q.&nbsp;{{ number_format($tramite->gastos, 2) }}</td>
            <td style="padding:5px 5px; border-bottom:1px solid #e2e8f0; text-align:right; font-family:'Courier New',Courier,monospace;
                color:{{ ($tramite->precio - $tramite->gastos) >= 0 ? '#059669' : '#e11d48' }};">
                Q.&nbsp;{{ number_format($tramite->precio - $tramite->gastos, 2) }}
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr style="background:#eef2ff;">
            <td colspan="4" style="padding:6px 5px; font-weight:700; color:#312e81; border-top:2px solid #4f46e5; text-align:center; font-size:10px; text-transform:uppercase; letter-spacing:0.05em;">Totales del Período</td>
            <td style="padding:6px 5px; font-weight:700; color:#312e81; border-top:2px solid #4f46e5; text-align:right; font-family:'Courier New',Courier,monospace;">Q.&nbsp;{{ number_format($totalPrecio, 2) }}</td>
            <td style="padding:6px 5px; font-weight:700; color:#312e81; border-top:2px solid #4f46e5; text-align:right; font-family:'Courier New',Courier,monospace;">Q.&nbsp;{{ number_format($totalGastos, 2) }}</td>
            <td style="padding:6px 5px; font-weight:700; color:#059669; border-top:2px solid #4f46e5; text-align:right; font-family:'Courier New',Courier,monospace;">Q.&nbsp;{{ number_format($gastoTotal, 2) }}</td>
        </tr>
    </tfoot>
</table>

</body>
</html>
