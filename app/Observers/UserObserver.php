<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Bitacora;

class UserObserver
{
    // Bitacora al crear un usuario
    public function created(User $user): void
    {
        $adminUserId = User::where('role_id', 1)->first()->id ?? $user->id;
        
        Bitacora::create([
            'tipo' => 'creacion',
            'descripcion' => 'Usuario creado: ' . $user->nombres . ' ' . $user->apellidos,
            'user_id' => auth()->check() ? auth()->id() : $adminUserId,
        ]);
    }

    // Bitacora al eliminar un usuario
    public function deleted(User $user): void
    {
        Bitacora::create([
            'tipo' => 'eliminacion',
            'descripcion' => 'Usuario eliminado: ' . $user->nombres . ' ' . $user->apellidos,
            'user_id' => auth()->id(),
        ]);
    }
}
