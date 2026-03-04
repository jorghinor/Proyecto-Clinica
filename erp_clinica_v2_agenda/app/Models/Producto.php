<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'codigo_barras',
        'descripcion',
        'imagen_path', // Añadido
        'stock_minimo',
        'precio_venta',
    ];

    public function lotes(): HasMany
    {
        return $this->hasMany(Lote::class);
    }

    // Accesor para obtener el stock total actual
    public function getStockTotalAttribute(): int
    {
        return $this->lotes()->sum('cantidad_actual');
    }
}
