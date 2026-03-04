<?php

namespace App\Filament\Widgets;

use App\Models\Producto;
use Filament\Widgets\ChartWidget;

class ProductsChart extends ChartWidget
{
    protected static ?string $heading = 'Top 5 Productos con Mayor Stock';
    protected static ?int $sort = 3; // Orden en el dashboard

    protected function getData(): array
    {
        // Obtener los 5 productos con mayor stock total (calculado desde sus lotes)
        // Como stock_total es un accesor, necesitamos hacer la consulta sobre los lotes
        $productos = Producto::withSum('lotes', 'cantidad_actual')
            ->orderByDesc('lotes_sum_cantidad_actual')
            ->take(5)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Stock Disponible',
                    'data' => $productos->pluck('lotes_sum_cantidad_actual')->toArray(),
                    'backgroundColor' => '#36A2EB', // Azul
                    'borderColor' => '#36A2EB',
                ],
            ],
            'labels' => $productos->pluck('nombre')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
