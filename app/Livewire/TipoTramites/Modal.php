<?php

namespace App\Livewire\TipoTramites;

use Livewire\Component;

class Modal extends Component
{
    // Variables
    public $show = false;
    public $tipoTramiteId = null;

    // Eventos
    protected $listeners = ['crearTipoTramite', 'editarTipoTramite', 'cerrarModal'];

    // Abrir modal para crear
    public function crearTipoTramite()
    {
        $this->limpiarModal();
        $this->show = true;
    }

    // Abrir modal para editar
    public function editarTipoTramite($tipoTramiteId)
    {
        $this->tipoTramiteId = $tipoTramiteId;
        $this->show = true;

        $this->dispatch('cargarTipoTramite', $tipoTramiteId);
    }

    // Cerrar modal
    public function cerrarModal()
    {
        $this->show = false;
    }

    // Limpiar modal
    public function limpiarModal()
    {
        $this->tipoTramiteId = null;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.tipo-tramites.modal');
    }
}
