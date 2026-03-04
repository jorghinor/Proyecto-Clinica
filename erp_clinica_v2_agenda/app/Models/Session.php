<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Session extends Model
{
    /**
     * La tabla asociada al modelo.
     */
    protected $table = 'sessions';

    /**
     * Indicamos que la clave primaria es un string (el ID de sesión).
     */
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * Laravel gestiona esta tabla manualmente, no usa timestamps (created_at, updated_at)
     * sino una columna 'last_activity'.
     */
    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_id',
        'ip_address',
        'user_agent',
        'payload',
        'last_activity',
    ];

    /**
     * Relación con el usuario.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
