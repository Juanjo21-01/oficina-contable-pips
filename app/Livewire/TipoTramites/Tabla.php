<?php

namespace App\Livewire\TipoTramites;

use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\TipoTramite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class Tabla extends Component
{
    use WithPagination, WithoutUrlPagination;

    // Variables
    public $tipoTramiteId, $password, $nombre;
    public $abrirModal = false;
    public $search = '';
    public $perPage = 5;

    // Eventos
    protected $listeners = ['tipoTramiteGuardado' => 'render', 'tipoTramiteEliminado' => 'render'];

    // Abrir modal
    public function modalEliminar($tipoTramiteId)
    {
        if (Auth::user()->role->nombre !== 'Administrador') {
            $this->dispatch('toast', type: 'error', message: '¡No tienes permiso para eliminar tipos de trámites!');
            return;
        }

        $this->password = '';
        $this->clearError('password');

        $tipoTramite = TipoTramite::find($tipoTramiteId);

        $this->nombre = $tipoTramite->nombre;
        $this->tipoTramiteId = $tipoTramiteId;
        $this->abrirModal = true;
    }

    // Cerrar modal
    public function cerrarModal()
    {
        $this->abrirModal = false;
        $this->reset('tipoTramiteId');
    }

    // Crear
    public function crear()
    {
        $this->dispatch('crearTipoTramite');
    }

    // Editar
    public function editar($tipoTramiteId)
    {
        $this->dispatch('editarTipoTramite', $tipoTramiteId);
    }

    // Eliminar
    public function eliminar()
    {
        try {
            if (!Hash::check($this->password, Auth::user()->password)) {
                $this->addError('password', 'La contraseña es incorrecta.');
                return;
            }

            $tipoTramite = TipoTramite::find($this->tipoTramiteId);

            if ($tipoTramite->tramites->count() > 0) {
                $this->dispatch('toast', type: 'warning', message: '¡Existen trámites asociados!');
                return;
            }

            $tipoTramite->delete();

            $this->cerrarModal();
            $this->dispatch('tipoTramiteEliminado');
            $this->dispatch('toast', type: 'success', message: '¡Tipo de trámite eliminado!');
        } catch (\Exception $e) {
            $this->addError('password', 'Error al eliminar el tipo de trámite.'.$e->getMessage());
            $this->dispatch('toast', type: 'error', message: '¡Error al eliminar el tipo de trámite!');
        }
    }

    // Limpiar errores
    public function clearError($error)
    {
        $this->resetErrorBag($error);
    }

    // Resetear paginación al buscar
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = TipoTramite::query();

        if ($this->search) {
            $query->where('nombre', 'like', '%' . $this->search . '%');
        }

        $tipoTramites = $query->paginate($this->perPage);

        return view('livewire.tipo-tramites.tabla', [
            'tipoTramites' => $tipoTramites
        ]);
    }
}
