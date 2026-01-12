<?php

namespace App\Livewire\Reportes;

use Livewire\Component;
use App\Models\Tramite;
use App\Models\Cliente;
use App\Models\TipoTramite;
use Carbon\Carbon;

class Tabla extends Component
{
    public $filtrar, $reporte = [];
    public $fechaInicio, $fechaFin;
    public $tipoTramiteId, $clienteId;
    public $totalTramites, $gastoTotal, $promedioGasto;
    
    // Paginación
    public $perPage = 10;

    public function mount($filtrar)
    {
        $this->filtrar = $filtrar;
        $this->obtenerReportes();
    }

    // Obtener Reportes
    public function obtenerReportes()
    {
        switch ($this->filtrar) {
            case 'semana':
                $this->reporte = $this->getReporteSemana();
                break;
            case 'mes':
                $this->reporte = $this->getReporteMes();
                break;
            case 'rango':
                $this->reporte = $this->getReporteRango();
                break;
            default:
                $this->reporte = [];
                break;
        }
    }

    public function render()
    {
        $clientes = Cliente::where('estado', 1)->get();
        $tipoTramites = TipoTramite::all();
        return view('livewire.reportes.tabla', [
            'clientes' => $clientes,
            'tiposTramites' => $tipoTramites,
        ]);
    }

    protected function getReporteSemana()
    {
        // Fecha de inicio de la semana y fecha de fin de la semana
        $inicioSemana = Carbon::now()->startOfWeek();
        $finSemana = Carbon::now()->endOfWeek();

        // Consulta para obtener los trámites de la semana, que estén activos
        $query = Tramite::where('estado', 1)
            ->whereBetween('fecha', [$inicioSemana, $finSemana]);

        return $this->aplicarFiltros($query);
    }
    protected function getReporteMes()
    {
        // Fecha de inicio del mes y fecha de fin del mes
        $inicioMes = Carbon::now()->startOfMonth();
        $finMes = Carbon::now()->endOfMonth();

        // Consulta para obtener los trámites del mes, que estén activos
        $query = Tramite::where('estado', 1)
            ->whereBetween('fecha', [$inicioMes, $finMes]);

        return $this->aplicarFiltros($query);
    }
    protected function getReporteRango()
    {
        // Verificar que las fechas no estén vacías
        if ($this->fechaInicio && $this->fechaFin) {
            // Convertir las fechas a objetos Carbon
            $inicio = Carbon::parse($this->fechaInicio)->startOfDay();
            $fin = Carbon::parse($this->fechaFin)->endOfDay();

            // Consulta para obtener los trámites del rango de fechas, que estén activos
            $query = Tramite::where('estado', 1)
                ->whereBetween('fecha', [$inicio, $fin]);

            return $this->aplicarFiltros($query);
        }

        return collect();
    }

    protected function aplicarFiltros($query)
    {
        // Filtrar por tipo de trámite
        if ($this->tipoTramiteId) {
            $query->where('tipo_tramite_id', $this->tipoTramiteId);
        }

        // Filtrar por cliente
        if ($this->clienteId) {
            $query->where('cliente_id', $this->clienteId);
        }

        $tramites = $query->orderBy('fecha', 'desc')->get();

        // Calcular el total de trámites
        $this->totalTramites = $tramites->count();
        // Calcular el gasto total
        $this->gastoTotal = $tramites->sum('precio') - $tramites->sum('gastos');
        // Calcular el promedio de gastos
        $this->promedioGasto = $this->totalTramites > 0 ? $this->gastoTotal / $this->totalTramites : 0;

        return $tramites;
    }
}
