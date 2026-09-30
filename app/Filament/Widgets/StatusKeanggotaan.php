<?php

namespace App\Filament\Widgets;

use App\Models\keanggotaan;
use Filament\Widgets\ChartWidget;

class StatusKeanggotaan extends ChartWidget
{
    protected ?string $heading = 'Status Keanggotaan';

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $aktif = keanggotaan::where('status', 'Aktif')->count();
        $nonaktif = keanggotaan::where('status', 'Nonaktif')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Status Keanggotaan',
                    'data' => [$aktif, $nonaktif],
                    'backgroundColor' => [
                        '#AAFFC7',
                        '#67C090',
                    ],
                ],
            ],
            'labels' => ['Aktif', 'Nonaktif'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}