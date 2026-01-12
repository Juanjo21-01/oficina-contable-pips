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
        // Buscar TipoTramite
        $tipoTramite = TipoTramite::find($tipoTramiteId);

        // Asignar valores
        $this->tipoTramiteId = $tipoTramite->id;
        $this->nombre = $tipoTramite->nombre;
    }

    // Guardar
    public function guardar()
    {
        // Validar
        $this->validate([
            'nombre' => 'required|string|min:3|max:100|unique:tipo_tramites,nombre,' . $this->tipoTramiteId
        ]);
        
        try{
            // Si se esta editando
            if ($this->tipoTramiteId) {
                // Buscar TipoTramite
                $tipoTramite = TipoTramite::find($this->tipoTramiteId);
                
                // Guardar
                $tipoTramite->nombre = $this->nombre;
                $tipoTramite->save();

                // Emitir evento
                $this->dispatch('tipoTramiteGuardado');

                 // Mostrar mensaje
                toastr()->addInfo('Tipo de trámite actualizado!', [
                    'positionClass' => 'toast-bottom-right',
                    'closeButton' => true,
                ]);
            } else {
                // Crear TipoTramite
                TipoTramite::create([
                    'nombre' => $this->nombre
                ]);

                // Emitir evento
                $this->dispatch('tipoTramiteGuardado');

                // Mostrar mensaje
                toastr()->addSuccess('Tipo de trámite creado!', [
                    'positionClass' => 'toast-bottom-right',
                    'closeButton' => true,
                ]);
            }
            // Cerrar modal
            $this->dispatch('cerrarModal');
        } catch (\Exception $e) {
            $this->errorMessage = 'Error al guardar el tipo de trámite: ' . $e->getMessage();

            // Mostrar mensaje
            toastr()->addError($this->errorMessage, [
                'positionClass' => 'toast-bottom-right',
                'closeButton' => true,
            ]);
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
