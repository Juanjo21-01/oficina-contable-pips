<?php

namespace App\Livewire\Tramites;

use Livewire\Component;
use App\Models\Tramite;

class Detalle extends Component
{
    // Variables
    public $tramite, $tramiteId;

    // Eventos
    protected $listeners = ['tramiteGuardado' => 'render'];

    // Constructor
    public function mount($id)
    {
        $this->tramiteId = $id;
        $this->tramite = Tramite::find($id);
    }

    // Editar
    public function editar($tramiteId)
    {
        $this->dispatch('editarTramite', $tramiteId);
    }

    // Cambiar estado
    public function cambiarEstado($tramiteId)
    {
        // Buscar tramite
        $tramite = Tramite::find($tramiteId);


        // Cambiar estado
        $tramite->estado = !$tramite->estado;
        $tramite->save();

        // Mostrar mensaje
        toastr()->addSuccess('¡Estado actualizado!', [
            'positionClass' => 'toast-bottom-right',
            'closeButton' => true,
        ]);
    }

    public function render()
    {
        $this->tramite = Tramite::find($this->tramiteId);
        return view('livewire.tramites.detalle', [
            'tramite' => $this->tramite
        ]);
    }
}
