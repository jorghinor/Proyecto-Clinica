<?php

namespace App\Filament\Widgets;

use App\Models\Factura;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class IngresosChart extends ChartWidget
{
    protected static ?string $heading = 'Ingresos Mensuales (Facturas Pagadas)';

    protected static ?int $sort = 1; // Que aparezca primero

    protected int | string | array $columnSpan = 'full'; // Que ocupe todo el ancho

    protected function getData(): array
    {
        // Obtenemos los ingresos de los últimos 6 meses
        $data = Factura::select(
                DB::raw("to_char(fecha_emision, 'YYYY-MM') as mes"), // PostgreSQL syntax
                DB::raw('SUM(total) as total')
            )
            ->where('estado', 'pagada')
            ->where('fecha_emision', '>=', now()->subMonths(6))
            ->groupBy('mes')
            ->orderBy('mes')
            ->pluck('total', 'mes')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Ingresos ($)',
                    'data' => array_values($data),
                    'backgroundColor' => '#3b82f6', // Azul
                    'borderColor' => '#2563eb',
                ],
            ],
            'labels' => array_keys($data),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
