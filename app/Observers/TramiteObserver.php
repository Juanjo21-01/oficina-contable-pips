<?php

namespace App\Observers;

use App\Models\Tramite;
use App\Models\Bitacora;

class TramiteObserver
{
    // Bitacora al crear un trámite
    public function created(Tramite $tramite): void
    {
        Bitacora::create([
            'tipo' => 'creacion',
            'descripcion' => 'Trámite ingresado de: ' . $tramite->cliente->nombres . ' ' . $tramite->cliente->apellidos . ' - ' . $tramite->tipoTramite->nombre,
            'user_id' => auth()->id(),
        ]);
    }

    // Bitacora al eliminar un trámite
    public function deleted(Tramite $tramite): void
    {
        Bitacora::create([
            'tipo' => 'eliminacion',
            'descripcion' => 'Trámite eliminado de: ' . $tramite->cliente->nombres . ' ' . $tramite->cliente->apellidos . ' - ' . $tramite->tipoTramite->nombre . ' - Precio: ' . $tramite->precio . ' - Gastos: ' . $tramite->gastos,
            'user_id' => auth()->id(),
        ]);
    }
}
