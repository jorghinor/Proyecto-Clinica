<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_paciente',
        'testimonio',
        'foto_paciente_path',
        'es_visible',
    ];

    protected $casts = [
        'es_visible' => 'boolean',
    ];
}
