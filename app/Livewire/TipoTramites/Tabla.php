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
         // Solo los administradores pueden eliminar tipos de trámites
        if (Auth::user()->role->nombre !== 'Administrador') {
            return toastr()->addError('¡No tienes permiso para eliminar tipos de trámites!', [
                'positionClass' => 'toast-bottom-right',
                'closeButton' => true,
            ]);
        }

        $this->password = '';
        $this->clearError('password');

        // Buscar tipo de trámite
        $tipoTramite = TipoTramite::find($tipoTramiteId);

        // Asignar valores
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
            // Validar contraseña
            if (!Hash::check($this->password, Auth::user()->password)) {
                $this->addError('password', 'La contraseña es incorrecta.');
                return;
            }

            // Buscar tipo de trámite
            $tipoTramite = TipoTramite::find($this->tipoTramiteId);

            // Verificar si el tipo de trámite tiene trámites asociados
            if ($tipoTramite->tramites->count() > 0) {
                toastr()->addWarning('¡Existen trámites asociados!', [
                    'positionClass' => 'toast-bottom-right',
                    'closeButton' => true,
                ]);
                return;
            }

            // Eliminar tipo de trámite
            $tipoTramite->delete();

            // Cerrar modal
            $this->cerrarModal();
            $this->dispatch('tipoTramiteEliminado');

            // Mostrar mensaje
            toastr()->addSuccess('Tipo de trámite eliminado!', [
                'positionClass' => 'toast-bottom-right',
                'closeButton' => true,
            ]);
        } catch (\Exception $e) {
            $this->addError('password', 'Error al eliminar el tipo de trámite.'.$e->getMessage());
            toastr()->addError('¡Error al eliminar el tipo de trámite!', [
                'positionClass' => 'toast-bottom-right',
                'closeButton' => true,
            ]);
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

        // Filtrar por nombre
        if ($this->search) {
            $query->where('nombre', 'like', '%' . $this->search . '%');
        }

        // Obtener los tipos de trámites paginados
        $tipoTramites = $query->paginate($this->perPage);

        return view('livewire.tipo-tramites.tabla', [
            'tipoTramites' => $tipoTramites
        ]);
    }
}
