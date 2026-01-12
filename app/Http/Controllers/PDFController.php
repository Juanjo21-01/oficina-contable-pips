<?php

namespace App\Http\Controllers;

use App\Models\Tramite;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Bitacora;

class PDFController extends Controller
{
    // PDF de recibo de tramite
    public function reciboPDF(string $id)
    {
        // Buscar el tramite
        $tramite = Tramite::find($id);

        // Si no existe el tramite
        if (!$tramite) {
            toastr()->addWarning('¡El trámite no existe!', [
                'positionClass' => 'toast-bottom-right',
                'closeButton' => true,
                ]);
            return redirect()->back();
        }

        // Generar PDF
        $pdf = PDF::loadView('pdf.recibo', compact('tramite'));

        // Descargar PDF
        return $pdf->stream('Trámite No. ' . $tramite->id . ' - '.$tramite->cliente->nombres.'.pdf');
    }

    // PDF de reporte de tramites
    public function reportePDF(string $tipo, Request $request)
    {
        // Validar que no vengan las fechas vacias
        if ($tipo === 'rango' && (!$request->fechaInicio || !$request->fechaFin)) {
            toastr()->addError('¡Debes seleccionar un rango de fechas!', [
                'positionClass' => 'toast-bottom-right',
                'closeButton' => true,
            ]);
            return redirect()->back();
        }

        // Obtener los datos del reporte
        $reporte = $this->getReporte($tipo, $request->fechaInicio, $request->fechaFin, $request->tipoTramiteId, $request->clienteId);

        // Si no existen tramites
        if ($reporte['tramites']->isEmpty()) {
            toastr()->addWarning('¡No hay trámites registrados en esta fecha!', [
                'positionClass' => 'toast-bottom-right',
                'closeButton' => true,
            ]);
            return redirect()->back();
        }

        // Nombre del archivo
        $nombreArchivo = match ($tipo) {
            'semana' => 'Reporte semanal del ' . Carbon::now()->startOfWeek()->format('d-m-Y') . ' al ' . Carbon::now()->endOfWeek()->format('d-m-Y') . '.pdf',
            'mes' => 'Reporte del mes de ' . Carbon::now()->monthName . '.pdf',
            default => 'Reporte del ' . Carbon::parse($request->fechaInicio)->format('d-m-Y') . ' al ' . Carbon::parse($request->fechaFin)->format('d-m-Y') . '.pdf',
        };

        // Generar PDF
        $reporte['nombreArchivo'] = $nombreArchivo;
        $pdf = PDF::loadView('pdf.reporte', $reporte);

        // Bitacora
        Bitacora::create([
            'tipo' => 'reporte',
            'descripcion' => 'El usuario: ' . auth()->user()->nombres . ', generó el ' . $nombreArchivo,
            'user_id' => auth()->id(),
        ]);
        
        // Descargar PDF
        return $pdf->download($nombreArchivo);
    }

    protected function getReporte(string $tipo, $fechaInicio = null, $fechaFin = null, $tipoTramiteId = null, $clienteId = null)
    {
        $reporte = collect();
        switch ($tipo) {
            case 'semana':
                $reporte = $this->getReporteSemana($tipoTramiteId, $clienteId);
                break;
            case 'mes':
                $reporte = $this->getReporteMes($tipoTramiteId, $clienteId);
                break;
            case 'rango':
                $reporte = $this->getReporteRango($fechaInicio, $fechaFin, $tipoTramiteId, $clienteId);
                break;
            default:
                break;
        }
        return $reporte;
    }

    protected function getReporteSemana($tipoTramiteId, $clienteId)
    {
        $inicioSemana = Carbon::now()->startOfWeek();
        $finSemana = Carbon::now()->endOfWeek();
        $query = Tramite::where('estado', 1)->whereBetween('fecha', [$inicioSemana, $finSemana]);
        return $this->aplicarFiltros($query, $tipoTramiteId, $clienteId);
    }

    protected function getReporteMes($tipoTramiteId, $clienteId)
    {
        $inicioMes = Carbon::now()->startOfMonth();
        $finMes = Carbon::now()->endOfMonth();
        $query = Tramite::where('estado', 1)->whereBetween('fecha', [$inicioMes, $finMes]);
        return $this->aplicarFiltros($query, $tipoTramiteId, $clienteId);
    }

    protected function getReporteRango($fechaInicio, $fechaFin, $tipoTramiteId, $clienteId)
    {
        if ($fechaInicio && $fechaFin) {
            $inicio = Carbon::parse($fechaInicio)->startOfDay();
            $fin = Carbon::parse($fechaFin)->endOfDay();
            $query = Tramite::where('estado', 1)->whereBetween('fecha', [$inicio, $fin]);
            return $this->aplicarFiltros($query, $tipoTramiteId, $clienteId);
        }
        return collect();
    }

    protected function aplicarFiltros($query, $tipoTramiteId, $clienteId)
    {
        if ($tipoTramiteId) {
            $query->where('tipo_tramite_id', $tipoTramiteId);
        }
        if ($clienteId) {
            $query->where('cliente_id', $clienteId);
        }
        $tramites = $query->orderBy('fecha', 'desc')->get();
        return [
            'tramites' => $tramites,
            'totalTramites' => $tramites->count(),
            'totalPrecio' => $tramites->sum('precio'),
            'totalGastos' => $tramites->sum('gastos'),
            'gastoTotal' => $tramites->sum('precio') - $tramites->sum('gastos'),
            'promedioGasto' => $tramites->count() > 0 ? ($tramites->sum('precio') - $tramites->sum('gastos')) / $tramites->count() : 0,
        ];
    }
}
