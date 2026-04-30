<?php

namespace App\Livewire\Tramites;

use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Tramite;
use App\Models\TipoTramite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Tabla extends Component
{
    use WithPagination, WithoutUrlPagination;

    // Variables
    public $tramiteId, $password, $clienteNombre, $tipoTramiteNombre, $fecha;
    public $abrirModal = false;
    public $search = '';
    public $estado = '';
    public $perPage = 10;

    // Eventos
    protected $listeners = ['tramiteGuardado' => 'render', 'tramiteEliminado' => 'render'];

    // Abrir modal
    public function modalEliminar($tramiteId)
    {
        if (Auth::user()->role->nombre !== 'Administrador') {
            $this->dispatch('toast', type: 'error', message: '¡No tienes permiso para eliminar trámites!');
            return;
        }

        $this->password = '';
        $this->clearError('password');

        $tramite = Tramite::find($tramiteId);

        $this->clienteNombre = $tramite->cliente->nombres . ' ' . $tramite->cliente->apellidos;
        $this->tipoTramiteNombre = $tramite->tipoTramite->nombre;
        $this->fecha = $tramite->fecha;

        $this->tramiteId = $tramiteId;
        $this->abrirModal = true;
    }

    // Cerrar modal
    public function cerrarModal()
    {
        $this->abrirModal = false;
        $this->reset('tramiteId');
    }

    // Editar
    public function editar($tramiteId)
    {
        $this->dispatch('editarTramite', $tramiteId);
    }

    // Eliminar
    public function eliminar()
    {
        try {
            if (!Hash::check($this->password, Auth::user()->password)) {
                $this->addError('password', 'La contraseña es incorrecta.');
                return;
            }

            $tramite = Tramite::find($this->tramiteId);
            $tramite->delete();

            $this->abrirModal = false;
            $this->dispatch('tramiteEliminado');
            $this->dispatch('toast', type: 'success', message: 'Trámite eliminado.');
        } catch (\Exception $e) {
            $this->addError('password', 'Error al eliminar el trámite.'.$e->getMessage());
            $this->dispatch('toast', type: 'error', message: '¡Error al eliminar el trámite!');
        }
    }

    // Limpiar errores
    public function clearError($field)
    {
        $this->resetErrorBag($field);
    }

    // Cambiar estado
    public function cambiarEstado($tramiteId)
    {
        $tramite = Tramite::find($tramiteId);
        $tramite->update(['estado' => !$tramite->estado]);

        $this->dispatch('toast', type: 'success', message: 'Estado actualizado.');
    }

    // Resetear paginación al buscar
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingEstado()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Tramite::query();

        if ($this->search) {
            $query->whereHas('cliente', function ($q) {
                $q->where('nombres', 'like', '%' . $this->search . '%')
                ->orWhere('apellidos', 'like', '%' . $this->search . '%');
            })->orWhereHas('tipoTramite', function ($q) {
                $q->where('nombre', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->estado !== '') {
            $query->where('estado', $this->estado);
        }

        $query->orderBy('created_at', 'desc');

        $tramites = $query->paginate($this->perPage);

        return view('livewire.tramites.tabla', [
            'tramites' => $tramites
        ]);
    }
}
