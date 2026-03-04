<?php

namespace App\Filament\Widgets;

use App\Models\Cita;
use Filament\Widgets\ChartWidget;

class CitasChart extends ChartWidget
{
    protected static ?string $heading = 'Estado de Citas';

    protected static ?int $sort = 2; // Orden en el dashboard

    protected function getData(): array
    {
        $data = Cita::selectRaw('estado, count(*) as total')
            ->groupBy('estado')
            ->pluck('total', 'estado')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Citas',
                    'data' => array_values($data),
                    'backgroundColor' => [
                        '#f59e0b', // Warning (Reservado)
                        '#10b981', // Success (Atendido)
                        '#ef4444', // Danger (Cancelado)
                    ],
                ],
            ],
            'labels' => array_keys($data),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
