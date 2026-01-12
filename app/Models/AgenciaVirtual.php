<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgenciaVirtual extends Model
{
    // Nombre de la tabla
    protected $table = 'agencia_virtual';

    // Campos que se pueden llenar
    protected $fillable = [
        'cliente_id',
        'correo',
        'password',
        'observaciones',
    ];

    // Relación uno a uno
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

}
