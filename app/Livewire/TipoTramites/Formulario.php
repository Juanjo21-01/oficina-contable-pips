<?php

namespace App\Livewire\TipoTramites;

use Livewire\Component;
use App\Models\TipoTramite;

class Formulario extends Component
{
    // Variables
    public $nombre, $tipoTramiteId = null;
    public $errorMessage;

    // Eventos
    protected $listeners = ['cargarTipoTramite'];

    // Constructor
    public function mount($tipoTramiteId = null)
    {
        if ($tipoTramiteId) {
            $this->cargarTipoTramite($tipoTramiteId);
        }
    }

    // Cargar Tipo de Tramite
    public function cargarTipoTramite($tipoTramiteId)
    {
        $tipoTramite = TipoTramite::find($tipoTramiteId);

        $this->tipoTramiteId = $tipoTramite->id;
        $this->nombre = $tipoTramite->nombre;
    }

    // Guardar
    public function guardar()
    {
        $this->validate([
            'nombre' => 'required|string|min:3|max:100|unique:tipo_tramites,nombre,' . $this->tipoTramiteId
        ]);

        try {
            if ($this->tipoTramiteId) {
                $tipoTramite = TipoTramite::find($this->tipoTramiteId);
                $tipoTramite->nombre = $this->nombre;
                $tipoTramite->save();

                $this->dispatch('tipoTramiteGuardado');
                $this->dispatch('toast', type: 'info', message: '¡Tipo de trámite actualizado!');
            } else {
                TipoTramite::create(['nombre' => $this->nombre]);

                $this->dispatch('tipoTramiteGuardado');
                $this->dispatch('toast', type: 'success', message: '¡Tipo de trámite creado!');
            }
            $this->dispatch('cerrarModal');
        } catch (\Exception $e) {
            $this->errorMessage = 'Error al guardar el tipo de trámite: ' . $e->getMessage();
            $this->dispatch('toast', type: 'error', message: $this->errorMessage);
        }
    }

    // Limpiar errores
    public function clearError($field)
    {
        $this->resetErrorBag($field);
    }

    // Cerrar modal
    public function cerrarModal()
    {
        $this->dispatch('cerrarModal');
    }

    public function render()
    {
        return view('livewire.tipo-tramites.formulario');
    }
}
