<?php

namespace App\Livewire\Tramites;

use Livewire\Component;
use App\Models\Tramite;
use App\Models\Cliente;
use App\Models\TipoTramite;

class Formulario extends Component
{
    // Variables
    public $fecha, $precio, $gastos = 0, $observaciones, $tipoTramiteId, $clienteId;
    public $tramiteId = null;
    public $errorMessage;
    public $buscarCliente = '', $buscarTipoTramite = '';
    public $clientes = [], $tiposTramites = [];

    // Eventos
    protected $listeners = ['cargarTramite'];

    // Constructor
    public function mount($tramiteId = null)
    {
        if ($tramiteId) {
            $this->cargarTramite($tramiteId);
        }

        $this->clientes = Cliente::where('estado', 1)->get();
        $this->tiposTramites = TipoTramite::all();
    }

    // Guardar
    public function guardar()
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
            $tramite = Tramite::create([
                'fecha' => $this->fecha,
                'precio' => $this->precio,
                'gastos' => $this->gastos,
                'observaciones' => $this->observaciones,
                'tipo_tramite_id' => $this->tipoTramiteId,
                'cliente_id' => $this->clienteId,
                'user_id' => auth()->user()->id
            ]);

            $this->tramiteId = $tramite->id;
            $this->dispatch('tramiteGuardado');

            session()->flash('success', '¡Trámite guardado!');

            return redirect()->route('tramites.index');
        } catch (\Exception $e) {
            $this->errorMessage = 'Error al guardar el trámite: '.$e->getMessage();
            $this->dispatch('toast', type: 'error', message: $this->errorMessage);
        }
    }

    // Limpiar errores
    public function clearError($field)
    {
        $this->resetErrorBag($field);
    }

    // Buscar cliente
    public function updatedBuscarCliente()
    {
        $this->clientes = Cliente::where('estado', 1)
            ->where(function($query) {
                $query->where('nombres', 'like', '%' . $this->buscarCliente . '%')
                ->orWhere('apellidos', 'like', '%' . $this->buscarCliente . '%');
            })
            ->get();
    }

    // Buscar tipo de trámite
    public function updatedBuscarTipoTramite()
    {
        $this->tiposTramites = TipoTramite::where('nombre', 'like', '%' . $this->buscarTipoTramite . '%')
            ->get();
    }

    public function render()
    {
        return view('livewire.tramites.formulario', [
            'tiposTramites' => $this->tiposTramites,
            'clientes' => $this->clientes
        ]);
    }
}
