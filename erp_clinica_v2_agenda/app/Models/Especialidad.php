<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Especialidad extends Model
{
    use HasFactory;

    protected $table = 'especialidades'; // Especificamos la tabla porque el plural en español es irregular

    protected $fillable = [
        'nombre',
    ];

    public function medicos(): HasMany
    {
        return $this->hasMany(Medico::class);
    }
}
