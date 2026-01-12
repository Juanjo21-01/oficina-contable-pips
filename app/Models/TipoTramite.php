<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoTramite extends Model
{
    // Nombre de la tabla
    protected $table = 'tipo_tramites';

    // Campos que se pueden llenar
    protected $fillable = ['nombre'];
    
    // Relación uno a muchos
    public function tramites(): HasMany
    {
        return $this->hasMany(Tramite::class);
    }
}
