<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tramite extends Model
{
    // Nombre de la tabla
    protected $table = 'tramites';

    // Campos que se pueden llenar
    protected $fillable = [
        'fecha',
        'estado',
        'precio',
        'gastos',
        'observaciones',
        'cliente_id',
        'tipo_tramite_id',
        'user_id',
    ];

    // Relación muchos a uno
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function tipoTramite(): BelongsTo
    {
        return $this->belongsTo(TipoTramite::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
