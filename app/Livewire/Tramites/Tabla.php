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
         // Solo los administradores pueden eliminar trámites
        if (Auth::user()->role->nombre !== 'Administrador') {
            return toastr()->addError('¡No tienes permiso para eliminar trámites!', [
                'positionClass' => 'toast-bottom-right',
                'closeButton' => true,
            ]);
        }

        $this->password = '';
        $this->clearError('password');

        // Buscar tramite
        $tramite = Tramite::find($tramiteId);

        // Asignar valores
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
            // Validar contraseña
            if (!Hash::check($this->password, Auth::user()->password)) {
                $this->addError('password', 'La contraseña es incorrecta.');
                return;
            }

            // Buscar tramite
            $tramite = Tramite::find($this->tramiteId);

            // Eliminar
            $tramite->delete();

            // Cerrar modal
            $this->abrirModal = false;
            $this->dispatch('tramiteEliminado');

            // Mostrar mensaje
            toastr()->addSuccess('Trámite eliminado.', [
                'positionClass' => 'toast-bottom-right',
                'closeButton' => true,
            ]);
        } catch (\Exception $e) {
            $this->addError('password', 'Error al eliminar el trámite.'.$e->getMessage());
            toastr()->addError('¡Error al eliminar el trámite!', [
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

    // Cambiar estado
    public function cambiarEstado($tramiteId)
    {
        // Buscar tramite
        $tramite = Tramite::find($tramiteId);

        // Cambiar estado
        $tramite->update([
            'estado' => !$tramite->estado
        ]);

        // Mostrar mensaje
        toastr()->addSuccess('Estado actualizado.', [
            'positionClass' => 'toast-bottom-right',
            'closeButton' => true,
        ]);
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

        // Filtrar por cliente o tipo de trámite
        if ($this->search) {
            $query->whereHas('cliente', function ($q) {
                $q->where('nombres', 'like', '%' . $this->search . '%')
                ->orWhere('apellidos', 'like', '%' . $this->search . '%');
            })->orWhereHas('tipoTramite', function ($q) {
                $q->where('nombre', 'like', '%' . $this->search . '%');
            });
        }

        // Filtrar por estado
        if ($this->estado !== '') {
            $query->where('estado', $this->estado);
        }

        // Ordenar de manera descendente
        $query->orderBy('created_at', 'desc');

        // Obtener los trámites paginados
        $tramites = $query->paginate($this->perPage);

        return view('livewire.tramites.tabla', [
            'tramites' => $tramites
        ]);
    }
}
