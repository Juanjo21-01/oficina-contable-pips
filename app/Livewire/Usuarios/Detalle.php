<?php

namespace App\Livewire\Usuarios;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Detalle extends Component
{
    // Variables
    public $usuario, $usuarioId;

    // Eventos
    protected $listeners = ['usuarioGuardado' => 'render'];

    // Constructor
    public function mount($id)
    {
        if (Auth::user()->role->nombre != 'Administrador') {
            abort(403);
        }

        $this->usuarioId = $id;
        $this->usuario = User::find($id);
    }

    // Editar
    public function editar($usuarioId)
    {
        if (Auth::user()->role->nombre !== 'Administrador') {
            $this->dispatch('toast', type: 'error', message: '¡No tienes permiso para editar usuarios!');
            return;
        }

        $this->dispatch('editarUsuario', $usuarioId);
    }

    // Cambiar estado
    public function cambiarEstado($usuarioId)
    {
        $usuario = User::find($usuarioId);

        if ($usuario->role->nombre == 'Administrador') {
            $this->dispatch('toast', type: 'error', message: '¡No puedes cambiar el estado de un administrador!');
            return;
        }

        $usuario->estado = !$usuario->estado;
        $usuario->save();

        $this->dispatch('toast', type: 'success', message: '¡Estado actualizado!');
    }

    public function render()
    {
        $this->usuario = User::find($this->usuarioId);

        $tramitesPorMes = $this->usuario->tramites()->selectRaw('DATE_FORMAT(fecha, "%Y-%m") as mes, COUNT(*) as cantidad')
            ->where('fecha', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->groupBy('mes')
            ->pluck('cantidad', 'mes')
            ->toArray();

        $clientesPorMes = $this->usuario->clientes()->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as mes, COUNT(*) as cantidad')
            ->where('created_at', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->groupBy('mes')
            ->pluck('cantidad', 'mes')
            ->toArray();

        $tramitesData = [];
        $clientesData = [];

        $mesesDato = collect();
        for ($i = 5; $i >= 0; $i--) {
            $mesesDato->push(Carbon::now()->subMonths($i)->format('Y-m'));
        }
        foreach ($mesesDato as $mes) {
            $mesKey = Carbon::parse($mes)->format('Y-m');
            $tramitesData[] = $tramitesPorMes[$mesKey] ?? 0;
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
                    'label' => 'Trámites',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'data' => $tramitesData,
                ],
                [
                    'label' => 'Clientes',
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'data' => $clientesData,
                ],
            ],
        ];

        return view('livewire.usuarios.detalle', [
            'usuario' => $this->usuario,
            'chartData' => $chartData,
        ]);
    }
}
