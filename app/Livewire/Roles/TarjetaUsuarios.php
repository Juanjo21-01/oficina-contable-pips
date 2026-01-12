<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use App\Models\Role;
use App\Models\User;

class TarjetaUsuarios extends Component
{
    // Variables
    public $usuarios, $roles, $verUsuarios = false;

    // Eventos
    protected $listeners = ['verUsuarios'];

    // Ver Usuarios
    public function verUsuarios($roleId)
    {
        // Buscar usuarios
        $usuarios = User::where('role_id', $roleId)->get();

        // Asignar usuarios
        $this->usuarios = $usuarios;

        // Mostrar usuarios
        $this->verUsuarios = true;
    }

    // Constructor
    public function mount()
    {
        $this->usuarios = [];
        $this->roles = Role::all();
    }

    // Cerrar vista
    public function cerrarUsuarios()
    {
        $this->verUsuarios = false;
    }

    public function render()
    {
        return view('livewire.roles.tarjeta-usuarios', [
            'usuarios' => $this->usuarios,
            'roles' => $this->roles
        ]);
    }
}
