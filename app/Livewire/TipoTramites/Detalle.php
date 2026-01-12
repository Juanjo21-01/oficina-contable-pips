<?php

namespace App\Livewire\TipoTramites;

use Livewire\Component;
use App\Models\TipoTramite;
use Carbon\Carbon;

class Detalle extends Component
{
    // Variables
    public $tipoTramite, $tipoTramiteId;

    // Eventos
    protected $listeners = ['tipoTramiteGuardado' => 'render'];

    // Constructor
    public function mount($id)
    {
        $this->tipoTramiteId = $id;
        $this->tipoTramite = TipoTramite::find($id);
    }

    // Editar
    public function editar($tipoTramiteId)
    {
        $this->dispatch('editarTipoTramite', $tipoTramiteId);
    }

    public function render()
    {
        $this->tipoTramite = TipoTramite::find($this->tipoTramiteId);

        // Datos para la gráfica
        $tramitesPorMes = $this->tipoTramite->tramites()->selectRaw('DATE_FORMAT(fecha, "%Y-%m") as mes, COUNT(*) as cantidad')
            ->where('fecha', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->groupBy('mes')
            ->pluck('cantidad', 'mes')
            ->toArray();

        $tramitesData = [];

        // Obtener los últimos 6 meses
        $mesesDato = collect();
        for ($i = 5; $i >= 0; $i--) {
            $mesesDato->push(Carbon::now()->subMonths($i)->format('Y-m'));
        }
        foreach ($mesesDato as $mes) {
            $mesKey = Carbon::parse($mes)->format('Y-m');
            $tramitesData[] = $tramitesPorMes[$mesKey] ?? 0;
        }

        $meses = collect();
        for ($i = 5; $i >= 0; $i--) {
            $meses->push(Carbon::now()->subMonths($i)->locale('es')->isoFormat('MMMM YYYY'));
        }

        $chartData = [
            'labels' => $meses,
            'datasets' => [
                [
                    'label' => 'Trámites',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'data' => $tramitesData,
                ],
            ],
        ];

        return view('livewire.tipo-tramites.detalle', [
            'tipoTramite' => $this->tipoTramite,
            'chartData' => $chartData,
        ]);
    }
}
