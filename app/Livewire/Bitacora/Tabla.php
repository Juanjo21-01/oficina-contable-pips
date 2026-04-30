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
        if (Auth::user()->role->nombre != 'Administrador') {
            abort(403);
        }
    }

    // Abrir modal
    public function modalEliminar($bitacoraId)
    {
        if (Auth::user()->role->nombre !== 'Administrador') {
            $this->dispatch('toast', type: 'error', message: '¡No tienes permiso para eliminar bitácoras!');
            return;
        }

        $this->password = '';
        $this->clearError('password');

        $bitacora = Bitacora::find($bitacoraId);

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
            if (!Hash::check($this->password, Auth::user()->password)) {
                $this->addError('password', 'La contraseña es incorrecta.');
                return;
            }

            $bitacora = Bitacora::find($this->bitacoraId);
            $bitacora->delete();

            $this->abrirModal = false;
            $this->dispatch('bitacoraEliminado');
            $this->dispatch('toast', type: 'success', message: 'Bitácora eliminada.');
        } catch (\Exception $e) {
            $this->addError('password', 'Error al eliminar la bitácora.'.$e->getMessage());
            $this->dispatch('toast', type: 'error', message: '¡Error al eliminar la bitácora!');
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

        if ($this->search) {
            $query->whereHas('user', function ($q) {
                $q->where('nombres', 'like', '%' . $this->search . '%')
                ->orWhere('apellidos', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->tipo !== '') {
            $query->where('tipo', $this->tipo);
        }

        $query->orderBy('created_at', 'desc');

        $bitacoras = $query->paginate($this->perPage);

        return view('livewire.bitacora.tabla', [
            'bitacoras' => $bitacoras,
        ]);
    }
}
