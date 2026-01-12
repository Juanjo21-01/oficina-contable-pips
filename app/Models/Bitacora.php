<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bitacora extends Model
{
    // Nombre de la tabla
    protected $table = 'bitacoras';

    // Campos que se pueden llenar
    protected $fillable = [
        'tipo',
        'descripcion',
        'user_id',
    ];

    // Relación muchos a uno
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
