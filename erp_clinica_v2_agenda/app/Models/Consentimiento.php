<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Consentimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id',
        'titulo',
        'contenido_legal',
        'firma_digital_path',
        'estado',
        'fecha_firma',
    ];

    protected $casts = [
        'fecha_firma' => 'datetime',
    ];

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class);
    }
}
