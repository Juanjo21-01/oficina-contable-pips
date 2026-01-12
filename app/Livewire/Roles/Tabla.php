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
        // Solo los administradores pueden acceder
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
        // Solo los administradores pueden ver usuarios en cada rol
        if (Auth::user()->role->nombre !== 'Administrador') {
            return toastr()->addError('¡No tienes permiso para ver los usuarios del rol!', [
                'positionClass' => 'toast-bottom-right',
                'closeButton' => true,
            ]);
        }

        $this->dispatch('verUsuarios', $verUsuarios);
    }
}
