<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class Tabla extends Component
{
    // Variables
    public $roles;

    // Constructor
    public function mount()
    {
        if (Auth::user()->role->nombre != 'Administrador') {
            abort(403);
        }

        $this->roles = Role::all();
    }

    public function render()
    {
        return view('livewire.roles.tabla', [
            'roles' => $this->roles
        ]);
    }

    // Ver usuarios de un rol
    public function verUsuarios($verUsuarios)
    {
        if (Auth::user()->role->nombre !== 'Administrador') {
            $this->dispatch('toast', type: 'error', message: '¡No tienes permiso para ver los usuarios del rol!');
            return;
        }

        $this->dispatch('verUsuarios', $verUsuarios);
    }
}
