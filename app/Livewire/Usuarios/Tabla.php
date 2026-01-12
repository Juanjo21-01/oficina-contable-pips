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
        // Solo los administradores pueden acceder
        if (Auth::user()->role->nombre != 'Administrador') {
            abort(403);
        }

        $this->usuarios = User::all();
    }

    // Abrir modal
    public function modalEliminar($usuarioId)
    {
        // Solo los administradores pueden eliminar usuarios
        if (Auth::user()->role->nombre !== 'Administrador') {
            return toastr()->addError('¡No tienes permiso para eliminar usuarios!', [
                'positionClass' => 'toast-bottom-right',
                'closeButton' => true,
            ]);
        }

        $this->password = '';
        $this->clearError('password');

       // Buscar usuario
        $usuario = User::find($usuarioId);

        // Asignar valores
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
        // Solo los administradores pueden editar
        if (Auth::user()->role->nombre !== 'Administrador') {
            return toastr()->addError('¡No tienes permiso para editar usuarios!', [
                'positionClass' => 'toast-bottom-right',
                'closeButton' => true,
            ]);
        }
        
        $this->dispatch('editarUsuario', $usuarioId);
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

            // Buscar usuario
            $usuario = User::find($this->usuarioId);

            // Verificar si el usuario tiene clientes
            if ($usuario->clientes->count() > 0) {
                toastr()->addWarning('¡El usuario tiene clientes asociados!', [
                'positionClass' => 'toast-bottom-right',
                'closeButton' => true,
                ]);
                return;
            }

            // Verificar si el usuario tiene tramites
            if ($usuario->tramites->count() > 0) {
                toastr()->addWarning('¡El usuario tiene trámites asociados!', [
                'positionClass' => 'toast-bottom-right',
                'closeButton' => true,
                ]);
                return;
            }

            // Eliminar usuario
            $usuario->delete();

            // Cerrar la modal
            $this->abrirModal = false;
            $this->dispatch('usuarioEliminado');

            // Mostrar mensaje
            toastr()->addSuccess('¡Usuario eliminado!', [
                'positionClass' => 'toast-bottom-right',
                'closeButton' => true,
            ]);
       } catch (\Exception $e) {
            $this->addError('password', 'Error al eliminar el cliente.'.$e->getMessage());
            toastr()->addError('¡Error al eliminar el cliente!', [
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
    public function cambiarEstado($usuarioId)
    {
        // Buscar usuario
        $usuario = User::find($usuarioId);

        // Verificar si el usuario tiene el rol de administrador
        if ($usuario->role->nombre == 'Administrador') {
            toastr()->addError('¡No puedes cambiar el estado de un administrador!', [
                'positionClass' => 'toast-bottom-right',
                'closeButton' => true,
            ]);
            return;
        }

        // Cambiar estado
        $usuario->estado = !$usuario->estado;
        $usuario->save();

        // Mostrar mensaje
        toastr()->addSuccess('¡Estado actualizado!', [
            'positionClass' => 'toast-bottom-right',
            'closeButton' => true,
        ]);
    }

    public function render()
    {
        $this->usuarios = User::all();

        return view('livewire.usuarios.tabla', [
            'usuarios' => $this->usuarios
        ]);
    }
}
