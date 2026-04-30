<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo No. {{ $tramite->id }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 1.4cm 1.6cm 2.0cm 1.6cm;
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
            font-size: 12px;
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
     Col 1 (logo): 100px fijo
     Col 2 (empresa): auto
     Col 3 (meta): 210px fijo
     Tabla 100% → nunca desborda
--}}
<table width="100%" cellpadding="0" cellspacing="0"
       style="border-collapse:collapse; border-bottom:3px solid #4f46e5;">
    <tr>
        <td style="width:100px; vertical-align:middle; padding:0 8px 10px 0;">
            <img src="{{ public_path('img/logo.png') }}" alt="Logo" style="height:68px; display:block;">
        </td>
        <td style="vertical-align:middle; text-align:center; padding:0 8px 10px;">
            <div style="font-size:16px; font-weight:700; color:#312e81; margin-bottom:3px;">
                Méndez García &amp; Asociados
            </div>
            <div style="font-size:10px; color:#64748b; margin:2px 0;">Oficina Contable Autorizada</div>
            <div style="font-size:10px; color:#64748b; margin:2px 0;">10 7ª Avenida 3-40, Zona 2, San Pedro Sacatepéquez, San Marcos</div>
            <div style="font-size:10px; color:#64748b; margin:2px 0;">Tel: 5861-2987 &nbsp;|&nbsp; 5611-6232</div>
        </td>
        <td style="width:210px; vertical-align:top; padding:0 0 10px 8px;">
            <div style="background:#4f46e5; color:#fff; font-size:10px; font-weight:700;
                        padding:5px 8px; border-radius:4px; margin-bottom:6px; text-align:center;">
                RECIBO DE TRÁMITE
            </div>
            {{-- Meta: 90px label + 120px valor = 210px --}}
            <table width="210" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                <tr>
                    <td style="width:90px; font-size:10px; color:#64748b; padding:2px 0;">No. Recibo:</td>
                    <td style="width:120px; font-size:10px; font-weight:700; text-align:right; padding:2px 0;" class="mono">
                        #{{ str_pad($tramite->id, 5, '0', STR_PAD_LEFT) }}
                    </td>
                </tr>
                <tr>
                    <td style="font-size:10px; color:#64748b; padding:2px 0;">Fecha:</td>
                    <td style="font-size:10px; font-weight:700; text-align:right; padding:2px 0;">{{ date('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td style="font-size:10px; color:#64748b; padding:2px 0;">Atendido por:</td>
                    <td style="font-size:10px; font-weight:700; text-align:right; padding:2px 0;">{{ $tramite->user->nombres }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

{{-- ═══ SECCIÓN: CLIENTE ═══ --}}
<div style="font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.07em;
            color:#fff; background:#4f46e5; padding:4px 8px; margin-top:10px;">
    Información del Cliente
</div>
<div style="background:#f8fafc; border:1px solid #e2e8f0; border-top:none; padding:6px 8px;">
    {{-- 4 cols: 110 auto 20 90 auto --}}
    <table width="100%" cellpadding="3" cellspacing="0" style="border-collapse:collapse; table-layout:fixed;">
        <colgroup>
            <col style="width:110px;">
            <col>
            <col style="width:20px;">
            <col style="width:80px;">
            <col>
        </colgroup>
        <tr>
            <td style="font-size:11px; color:#64748b; font-weight:600;">Nombre completo:</td>
            <td style="font-size:11px; color:#0f172a;">{{ $tramite->cliente->nombres }} {{ $tramite->cliente->apellidos }}</td>
            <td></td>
            <td style="font-size:11px; color:#64748b; font-weight:600;">NIT:</td>
            <td style="font-size:11px; color:#0f172a;" class="mono">{{ $tramite->cliente->nit }}</td>
        </tr>
        <tr>
            <td style="font-size:11px; color:#64748b; font-weight:600;">Dirección:</td>
            <td style="font-size:11px; color:#0f172a;">{{ $tramite->cliente->direccion }}</td>
            <td></td>
            <td style="font-size:11px; color:#64748b; font-weight:600;">DPI:</td>
            <td style="font-size:11px; color:#0f172a;" class="mono">{{ $tramite->cliente->dpi ?: '—' }}</td>
        </tr>
        <tr>
            <td style="font-size:11px; color:#64748b; font-weight:600;">Teléfono:</td>
            <td style="font-size:11px; color:#0f172a;" class="mono">{{ $tramite->cliente->telefono }}</td>
            <td></td>
            <td style="font-size:11px; color:#64748b; font-weight:600;">Correo:</td>
            <td style="font-size:11px; color:#0f172a;">{{ $tramite->cliente->email }}</td>
        </tr>
    </table>
</div>

{{-- ═══ SECCIÓN: DETALLE ═══ --}}
<div style="font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.07em;
            color:#fff; background:#4f46e5; padding:4px 8px; margin-top:10px;">
    Detalle del Servicio
</div>
<table width="100%" cellpadding="0" cellspacing="0"
       style="border-collapse:collapse; table-layout:fixed;">
    <colgroup>
        <col style="width:36px;">
        <col>
        <col style="width:110px;">
        <col style="width:110px;">
    </colgroup>
    <thead>
        <tr style="background:#4f46e5;">
            <th style="font-size:10px; font-weight:700; color:#fff; text-transform:uppercase;
                       letter-spacing:0.04em; padding:6px 6px; text-align:center;">#</th>
            <th style="font-size:10px; font-weight:700; color:#fff; text-transform:uppercase;
                       letter-spacing:0.04em; padding:6px 6px; text-align:left;">Descripción del Servicio</th>
            <th style="font-size:10px; font-weight:700; color:#fff; text-transform:uppercase;
                       letter-spacing:0.04em; padding:6px 6px; text-align:center;">Fecha del Trámite</th>
            <th style="font-size:10px; font-weight:700; color:#fff; text-transform:uppercase;
                       letter-spacing:0.04em; padding:6px 6px; text-align:right;">Precio</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="font-size:11px; padding:8px 6px; border-bottom:1px solid #e2e8f0;
                       text-align:center; color:#1e293b;" class="mono">01</td>
            <td style="font-size:11px; padding:8px 6px; border-bottom:1px solid #e2e8f0; color:#1e293b;">
                {{ $tramite->tipoTramite->nombre }}
            </td>
            <td style="font-size:11px; padding:8px 6px; border-bottom:1px solid #e2e8f0;
                       text-align:center; color:#1e293b;">
                {{ date('d/m/Y', strtotime($tramite->fecha)) }}
            </td>
            <td style="font-size:11px; padding:8px 6px; border-bottom:1px solid #e2e8f0;
                       text-align:right; color:#1e293b;" class="mono">
                Q.&nbsp;{{ number_format($tramite->precio, 2) }}
            </td>
        </tr>
    </tbody>
</table>

{{-- ═══ TOTAL ═══
     Tabla 100%: col izq auto, col der 260px fijo
--}}
<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
    <tr>
        <td style="border-top:2px solid #4f46e5;"></td>
        <td style="width:260px; padding:0;">
            <div style="background:#eef2ff; border:1px solid #c7d2fe; border-top:2px solid #4f46e5;
                        padding:10px 14px; text-align:right;">
                <div style="font-size:9px; font-weight:700; text-transform:uppercase;
                             letter-spacing:0.08em; color:#6366f1; margin-bottom:2px;">Total a Pagar</div>
                <div style="font-size:26px; font-weight:700; color:#3730a3;
                             font-family:'Courier New',Courier,monospace; line-height:1;">
                    Q.&nbsp;{{ number_format($tramite->precio, 2) }}
                </div>
            </div>
        </td>
    </tr>
</table>

@if($tramite->observaciones)
{{-- ═══ OBSERVACIONES ═══ --}}
<div style="font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.07em;
            color:#fff; background:#4f46e5; padding:4px 8px; margin-top:10px;">
    Observaciones
</div>
<div style="background:#f0fdf4; border:1px solid #bbf7d0; border-left:3px solid #14b8a6;
            border-top:none; padding:7px 10px; font-size:11px; color:#334155; line-height:1.5;">
    {{ $tramite->observaciones }}
</div>
@endif

{{-- ═══ FIRMAS ═══
     2 celdas 50%/50% dentro de tabla 100%
--}}
<table width="100%" cellpadding="0" cellspacing="0"
       style="border-collapse:collapse; margin-top:30px;">
    <tr>
        <td style="width:50%; text-align:center; padding:0 24px; vertical-align:bottom;">
            <div style="height:42px;"></div>
            <div style="border-top:1px solid #94a3b8; padding-top:5px; font-size:10px; color:#64748b;">
                <strong style="font-size:11px; color:#334155; display:block; margin-bottom:2px;">
                    {{ $tramite->cliente->nombres }} {{ $tramite->cliente->apellidos }}
                </strong>
                Firma del Cliente
            </div>
        </td>
        <td style="width:50%; text-align:center; padding:0 24px; vertical-align:bottom;">
            {{-- Sello: div con border-radius, sin flexbox --}}
            <div style="width:80px; height:80px; border:2px dashed #a5b4fc; border-radius:40px;
                        margin:0 auto 4px auto; padding-top:26px;">
                <span style="font-size:9px; color:#a5b4fc; display:block; text-align:center;">Sello Oficial</span>
            </div>
            <div style="border-top:1px solid #94a3b8; padding-top:5px; font-size:10px; color:#64748b;">
                <strong style="font-size:11px; color:#334155; display:block; margin-bottom:2px;">
                    Méndez García &amp; Asociados
                </strong>
                Sello y Firma Autorizada
            </div>
        </td>
    </tr>
</table>

</body>
</html>
