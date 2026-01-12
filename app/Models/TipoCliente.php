<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoCliente extends Model
{
    // Nombre de la tabla
    protected $table = 'tipo_clientes';

    // Campos que se pueden llenar
    protected $fillable = ['nombre'];

    // Relación uno a muchos
    public function clientes(): HasMany
    {
        return $this->hasMany(Cliente::class);
    }
    
}
