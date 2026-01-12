<?php

namespace App\Observers;

use App\Models\TipoTramite;
use App\Models\Bitacora;

class TipoTramiteObserver
{
    // Bitacora al crear un tipo de trámite
    public function created(TipoTramite $tipoTramite): void
    {
        Bitacora::create([
            'tipo' => 'creacion',
            'descripcion' => 'Tipo de trámite creado: ' . $tipoTramite->nombre,
            'user_id' => auth()->id(),
        ]);
    }

    // Bitacora al eliminar un tipo de trámite
    public function deleted(TipoTramite $tipoTramite): void
    {
        Bitacora::create([
            'tipo' => 'eliminacion',
            'descripcion' => 'Tipo de trámite eliminado: ' . $tipoTramite->nombre,
            'user_id' => auth()->id(),
        ]);
    }
}
