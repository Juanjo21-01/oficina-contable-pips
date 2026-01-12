<?php

namespace App\Livewire\Usuarios;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;


class Formulario extends Component
{
    // Variables
    public $nombres, $apellidos, $email, $password, $estado, $roleId;
    public $usuarioId = null;
    public $errorMessage;

    // Eventos
    protected $listeners = ['cargarUsuario'];

    // Constructor
    public function mount($usuarioId = null)
    {
        if ($usuarioId) {
            $this->cargarUsuario($usuarioId);
        }
    }

    // Cargar Usuario
    public function cargarUsuario($usuarioId)
    {
        // Buscar usuario
        $usuario = User::find($usuarioId);

        // Asignar valores
        $this->usuarioId = $usuario->id;
        $this->nombres = $usuario->nombres;
        $this->apellidos = $usuario->apellidos;
        $this->email = $usuario->email;
        $this->estado = $usuario->estado;
        $this->roleId = $usuario->role_id;
    }

    // Guardar
    public function guardar()
    {
        // Validar
        $this->validate([
            'nombres' => 'required|string|max:50',
            'apellidos' => 'required|string|max:50',
            'email' => 'required|email|max:255|unique:users,email,' . $this->usuarioId,
            'password' => 'nullable|string|min:8|max:255',
            'roleId' => 'required|int|exists:roles,id'
        ]);
        
        try{
            // Si se esta editando
            if ($this->usuarioId) {
                // Buscar usuario
                $usuario = User::find($this->usuarioId);
                
                $usuario->nombres = $this->nombres;
                $usuario->apellidos = $this->apellidos;
                $usuario->email = $this->email;
                $usuario->estado = $this->estado;
                $usuario->role_id = $this->roleId;

                if ($this->password) {
                    $usuario->password = bcrypt($this->password);
                }

                // Guardar
                $usuario->save();

                // Emitir evento
                $this->dispatch('usuarioGuardado');

                // Mostrar mensaje
                toastr()->addInfo('¡Usuario actualizado!', [
                    'positionClass' => 'toast-bottom-right',
                    'closeButton' => true,
                ]);
            } else {

                // Validar contraseña
                $this->validate([
                    'password' => 'required|string|min:8|max:255'
                ]);

                // Crear usuario
                User::create([
                    'nombres' => $this->nombres,
                    'apellidos' => $this->apellidos,
                    'email' => $this->email,
                    'password' => bcrypt($this->password),
                    'role_id' => $this->roleId
                ]);

                // Emitir evento
                $this->dispatch('usuarioGuardado');

                // Mostrar mensaje
                toastr()->addSuccess('¡Usuario guardado!', [
                    'positionClass' => 'toast-bottom-right',
                    'closeButton' => true,
                ]);
            }
            // Cerrar modal
            $this->dispatch('cerrarModal');
            }
        catch(\Exception $e){
            $this->errorMessage = 'Error al guardar el usuario: '.$e->getMessage();

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
        $roles = Role::all()->except(1);
        return view('livewire.usuarios.formulario', [
            'roles' => $roles
        ]);
    }
}
