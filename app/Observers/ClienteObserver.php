<?php

namespace App\Observers;

use App\Models\Cliente;
use App\Models\Bitacora;

class ClienteObserver
{
    // Bitacora al crear un cliente
    public function created(Cliente $cliente): void
    {
        Bitacora::create([
            'tipo' => 'creacion',
            'descripcion' => 'Cliente ingresado: ' . $cliente->nombres . ' ' . $cliente->apellidos,
            'user_id' => auth()->id(),
        ]);
    }

    // Bitacora al eliminar un cliente
    public function deleted(Cliente $cliente): void
    {
        Bitacora::create([
            'tipo' => 'eliminacion',
            'descripcion' => 'Cliente eliminado: ' . $cliente->nombres . ' ' . $cliente->apellidos,
            'user_id' => auth()->id(),
        ]);
    }
}
