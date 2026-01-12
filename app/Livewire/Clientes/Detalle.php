<?php

namespace App\Livewire\Clientes;

use Livewire\Component;
use App\Models\Cliente;
use App\Models\AgenciaVirtual;
use Carbon\Carbon;

class Detalle extends Component
{
    // Variables
    public $cliente, $clienteId = null;
    public $abrirModalAgencia = false;
    public $correo, $contrasenia, $observaciones;
    public $errorMessage;

    // Eventos
    protected $listeners = ['clienteGuardado' => 'render'];

    // Constructor
    public function mount($id)
    {
        $this->clienteId = $id;
        $this->cliente = Cliente::find($id);
    }

    // Editar
    public function editar($clienteId)
    {
        $this->dispatch('editarCliente', $clienteId);
    }

    // Cambiar estado
    public function cambiarEstado($clienteId)
    {
        // Buscar cliente
        $cliente = Cliente::find($clienteId);

        // Cambiar estado
        $cliente->estado = !$cliente->estado;
        $cliente->save();

        // Mostrar mensaje
        toastr()->addSuccess('¡Estado actualizado!', [
            'positionClass' => 'toast-bottom-right',
            'closeButton' => true,
        ]);
    }

    // Abrir agencia
    public function abrirAgencia()
    {
        $this->limpiarFormulario();
        $this->abrirModalAgencia = true;
    }

    // Editar agencia
    public function editarAgencia()
    {
        $this->limpiarFormulario();

        $this->correo = $this->cliente->agenciaVirtual->correo;
        $this->contrasenia = $this->cliente->agenciaVirtual->password;
        $this->observaciones = $this->cliente->agenciaVirtual->observaciones;
        $this->abrirModalAgencia = true;
    }


    // Agregar agencia virtual
    public function agregarAgenciaVirtual()
    {
        // Validar
        $this->validate([
            'correo' => 'required|string|email|max:100',
            'contrasenia' => 'required|string|min:8|max:255',
            'observaciones' => 'nullable|string|max:255',
        ]);
        
        try {
            // Si se esta editando
            if ($this->cliente->agenciaVirtual) {
                // Actualizar agencia virtual
                $this->cliente->agenciaVirtual->where('cliente_id', $this->clienteId)->update([
                    'correo' => $this->correo,
                    'password' => $this->contrasenia,
                    'observaciones' => $this->observaciones,
                ]);

                // Mostrar mensaje
                toastr()->addInfo('¡Agencia Virtual actualizada!', [
                    'positionClass' => 'toast-bottom-right',
                    'closeButton' => true,
                ]);
            } else {
                // Crear agencia virtual
                AgenciaVirtual::create([
                    'cliente_id' => $this->clienteId,
                    'correo' => $this->correo,
                    'password' => $this->contrasenia,
                    'observaciones' => $this->observaciones,
                ]);

                // Mostrar mensaje
                toastr()->addSuccess('¡Agencia Virtual creada!', [
                    'positionClass' => 'toast-bottom-right',
                    'closeButton' => true,
                ]);
            }
            // Cerrar modal
            $this->abrirModalAgencia = false;
        } catch (\Exception $e) {
            $this->errorMessage = 'Error al guardar la agencia virtual: ' . $e->getMessage();
            // Mostrar mensaje
            toastr()->addError($this->errorMessage, [
                'positionClass' => 'toast-bottom-right',
                'closeButton' => true,
            ]);
        }
    }

    // Cerrar modal agencia
    public function cerrarModalAgencia()
    {
        $this->abrirModalAgencia = false;
    }

    // Limpiar errores
    public function clearError($field)
    {
        $this->resetErrorBag($field);
    }

    // Limpiar formulario
    public function limpiarFormulario()
    {
        $this->correo = null;
        $this->contrasenia = null;
        $this->observaciones = null;
        $this->errorMessage = null;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        $this->cliente = Cliente::find($this->clienteId);

        // Datos para la gráfica
        $tramitesPorMes = $this->cliente->tramites()->selectRaw('DATE_FORMAT(fecha, "%Y-%m") as mes, COUNT(*) as cantidad')
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

        return view('livewire.clientes.detalle', [
            'cliente' => $this->cliente,
            'chartData' => $chartData,
        ]);
    }
}
