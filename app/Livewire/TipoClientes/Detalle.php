<?php

namespace App\Livewire\TipoClientes;

use Livewire\Component;
use App\Models\TipoCliente;
use Carbon\Carbon;

class Detalle extends Component
{
    // Variables
    public $tipoCliente, $tipoClienteId;

    // Constructor
    public function mount($id)
    {
        $this->tipoClienteId = $id;
        $this->tipoCliente = TipoCliente::find($id);
    }

    public function render()
    {
        $this->tipoCliente = TipoCliente::find($this->tipoClienteId);

        // Datos para la gráfica
        $clientesPorMes = $this->tipoCliente->clientes()->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as mes, COUNT(*) as cantidad')
            ->where('created_at', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->groupBy('mes')
            ->pluck('cantidad', 'mes')
            ->toArray();

        $clientesData = [];

        // Obtener los últimos 6 meses
        $mesesDato = collect();
        for ($i = 5; $i >= 0; $i--) {
            $mesesDato->push(Carbon::now()->subMonths($i)->format('Y-m'));
        }
        foreach ($mesesDato as $mes) {
            $mesKey = Carbon::parse($mes)->format('Y-m');
            $clientesData[] = $clientesPorMes[$mesKey] ?? 0;
        }

        $meses = collect();
        for ($i = 5; $i >= 0; $i--) {
            $meses->push(Carbon::now()->subMonths($i)->locale('es')->isoFormat('MMMM YYYY'));
        }

        $chartData = [
            'labels' => $meses,
            'datasets' => [
                [
                    'label' => 'Clientes',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'data' => $clientesData,
                ],
            ],
        ];

        return view('livewire.tipo-clientes.detalle', [
            'tipoCliente' => $this->tipoCliente,
            'chartData' => $chartData,
        ]);
    }
}
