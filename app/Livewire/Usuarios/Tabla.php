<?php

namespace App\Livewire\Usuarios;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Tabla extends Component
{
    // Variables
    public $usuarios, $usuarioId, $password, $nombres, $apellidos;
    public $abrirModal = false;

    // Eventos
    protected $listeners = ['usuarioGuardado' => 'render', 'usuarioEliminado' => 'render'];

    // Constructor
    public function mount()
    {
        if (Auth::user()->role->nombre != 'Administrador') {
            abort(403);
        }

        $this->usuarios = User::all();
    }

    // Abrir modal
    public function modalEliminar($usuarioId)
    {
        if (Auth::user()->role->nombre !== 'Administrador') {
            $this->dispatch('toast', type: 'error', message: '¡No tienes permiso para eliminar usuarios!');
            return;
        }

        $this->password = '';
        $this->clearError('password');

        $usuario = User::find($usuarioId);

        $this->nombres = $usuario->nombres;
        $this->apellidos = $usuario->apellidos;

        $this->usuarioId = $usuarioId;
        $this->abrirModal = true;
    }

    // Cerrar modal
    public function cerrarModal()
    {
        $this->abrirModal = false;
        $this->reset('usuarioId');
    }

    // Crear
    public function crear()
    {
        $this->dispatch('crearUsuario');
    }

    // Editar
    public function editar($usuarioId)
    {
        if (Auth::user()->role->nombre !== 'Administrador') {
            $this->dispatch('toast', type: 'error', message: '¡No tienes permiso para editar usuarios!');
            return;
        }

        $this->dispatch('editarUsuario', $usuarioId);
    }

    // Eliminar
    public function eliminar()
    {
        try {
            if (!Hash::check($this->password, Auth::user()->password)) {
                $this->addError('password', 'La contraseña es incorrecta.');
                return;
            }

            $usuario = User::find($this->usuarioId);

            if ($usuario->clientes->count() > 0) {
                $this->dispatch('toast', type: 'warning', message: '¡El usuario tiene clientes asociados!');
                return;
            }

            if ($usuario->tramites->count() > 0) {
                $this->dispatch('toast', type: 'warning', message: '¡El usuario tiene trámites asociados!');
                return;
            }

            $usuario->delete();

            $this->abrirModal = false;
            $this->dispatch('usuarioEliminado');
            $this->dispatch('toast', type: 'success', message: '¡Usuario eliminado!');
        } catch (\Exception $e) {
            $this->addError('password', 'Error al eliminar el usuario.'.$e->getMessage());
            $this->dispatch('toast', type: 'error', message: '¡Error al eliminar el usuario!');
        }
    }

    // Limpiar errores
    public function clearError($field)
    {
        $this->resetErrorBag($field);
    }

    // Cambiar estado
    public function cambiarEstado($usuarioId)
    {
        $usuario = User::find($usuarioId);

        if ($usuario->role->nombre == 'Administrador') {
            $this->dispatch('toast', type: 'error', message: '¡No puedes cambiar el estado de un administrador!');
            return;
        }

        $usuario->estado = !$usuario->estado;
        $usuario->save();

        $this->dispatch('toast', type: 'success', message: '¡Estado actualizado!');
    }

    public function render()
    {
        $this->usuarios = User::all();

        return view('livewire.usuarios.tabla', [
            'usuarios' => $this->usuarios
        ]);
    }
}
