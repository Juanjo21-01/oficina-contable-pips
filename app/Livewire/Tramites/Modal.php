<?php

namespace App\Livewire\Tramites;

use Livewire\Component;
use App\Models\Tramite;
use App\Models\TipoTramite;
use App\Models\Cliente;

class Modal extends Component
{
    // Variables
    public $show = false;
    public $tramiteId = null;
    public $errorMessage;
    public $fecha, $precio, $gastos = 0, $observaciones, $tipoTramiteId, $clienteId;

    // Eventos
    protected $listeners = ['editarTramite'];

    // Abrir modal para editar
    public function editarTramite($tramiteId)
    {
        $this->limpiarModal();

        $tramite = Tramite::find($tramiteId);

        $this->tramiteId = $tramite->id;
        $this->fecha = $tramite->fecha;
        $this->precio = $tramite->precio;
        $this->gastos = $tramite->gastos;
        $this->observaciones = $tramite->observaciones;
        $this->tipoTramiteId = $tramite->tipo_tramite_id;
        $this->clienteId = $tramite->cliente_id;
        $this->show = true;
    }

    // Actualizar tramite
    public function actualizar()
    {
        $this->validate([
            'fecha' => 'required|date',
            'precio' => 'required|numeric|min:0',
            'gastos' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string|max:300',
            'tipoTramiteId' => 'required|int|exists:tipo_tramites,id',
            'clienteId' => 'required|int|exists:clientes,id'
        ]);

        try {
            $tramite = Tramite::find($this->tramiteId);
            $tramite->fecha = $this->fecha;
            $tramite->precio = $this->precio;
            $tramite->gastos = $this->gastos;
            $tramite->observaciones = $this->observaciones;
            $tramite->tipo_tramite_id = $this->tipoTramiteId;
            $tramite->cliente_id = $this->clienteId;
            $tramite->save();

            $this->dispatch('tramiteGuardado');
            $this->dispatch('toast', type: 'info', message: '¡Trámite actualizado!');

            $this->show = false;
        } catch (\Exception $e) {
            $this->errorMessage = 'Error al guardar el trámite: '.$e->getMessage();
            $this->dispatch('toast', type: 'error', message: $this->errorMessage);
        }
    }

    // Cerrar modal
    public function cerrarModal()
    {
        $this->show = false;
        $this->limpiarModal();
    }

    // Limpiar modal
    public function limpiarModal()
    {
        $this->tramiteId = null;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    // Limpiar errores
    public function clearError($field)
    {
        $this->resetErrorBag($field);
    }

    public function render()
    {
        $tiposTramites = TipoTramite::all();
        $clientes = Cliente::where('estado', 1)->get();
        return view('livewire.tramites.modal', [
            'tiposTramites' => $tiposTramites,
            'clientes' => $clientes
        ]);
    }
}
