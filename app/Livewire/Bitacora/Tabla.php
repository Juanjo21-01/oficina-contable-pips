<?php

namespace App\Livewire\Bitacora;

use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Tabla extends Component
{
    use WithPagination, WithoutUrlPagination;

    // Variables
    public $bitacoraId, $password, $usuarioNombre, $tipoBitacora, $abrirModal = false;
    public $search = '';
    public $tipo = '';
    public $perPage = 10;

    // Eventos
    protected $listeners = ['bitacoraGuardada' => 'render', 'bitacoraEliminada' => 'render'];

    // Constructor
    public function mount()
    {
        // Solo los administradores pueden acceder
        if (Auth::user()->role->nombre != 'Administrador') {
            abort(403);
        }
    }

    // Abrir modal
    public function modalEliminar($bitacoraId)
    {
         // Solo los administradores pueden eliminar bitácoras
        if (Auth::user()->role->nombre !== 'Administrador') {
            return toastr()->addError('¡No tienes permiso para eliminar bitácoras!', [
                'positionClass' => 'toast-bottom-right',
                'closeButton' => true,
            ]);
        }

        $this->password = '';
        $this->clearError('password');

        // Buscar bitacora
        $bitacora = Bitacora::find($bitacoraId);

        // Asignar valores
        $this->usuarioNombre = $bitacora->user->nombres . ' ' . $bitacora->user->apellidos;
        $this->tipoBitacora = $bitacora->tipo;

        $this->bitacoraId = $bitacoraId;
        $this->abrirModal = true;
    }

    // Cerrar modal
    public function cerrarModal()
    {
        $this->abrirModal = false;
        $this->reset('bitacoraId');
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

            // Buscar bitacora
            $bitacora = Bitacora::find($this->bitacoraId);

            // Eliminar
            $bitacora->delete();

            // Cerrar modal
            $this->abrirModal = false;
            $this->dispatch('bitacoraEliminado');

            // Mostrar mensaje
            toastr()->addSuccess('Bitácora eliminada.', [
                'positionClass' => 'toast-bottom-right',
                'closeButton' => true,
            ]);
        } catch (\Exception $e) {
            $this->addError('password', 'Error al eliminar la bitácora.'.$e->getMessage());
            toastr()->addError('¡Error al eliminar la bitácora!', [
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

    // Resetear paginación al buscar
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingTipo()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Bitacora::query();

        // Filtrar por usuario
        if ($this->search) {
            $query->whereHas('user', function ($q) {
                $q->where('nombres', 'like', '%' . $this->search . '%')
                ->orWhere('apellidos', 'like', '%' . $this->search . '%');
            });
        }

        // Filtrar por tipo
        if ($this->tipo !== '') {
            $query->where('tipo', $this->tipo);
        }

        // Ordenar de manera descendente
        $query->orderBy('created_at', 'desc');

        // Obtener bitacoras paginadas
        $bitacoras = $query->paginate($this->perPage);

        return view('livewire.bitacora.tabla', [
            'bitacoras' => $bitacoras,
        ]);
    }
}
