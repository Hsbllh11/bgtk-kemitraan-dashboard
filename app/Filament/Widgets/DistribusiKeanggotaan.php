<?php

namespace App\Filament\Widgets;

use App\Models\keanggotaan;
use Filament\Widgets\ChartWidget;

class DistribusiKeanggotaan extends ChartWidget
{
    protected ?string $heading = 'Distribusi Keanggotaan Berdasarkan Kabupaten / Kota';
    
    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $data = keanggotaan::query()
            ->selectRaw('kabupaten_kota, COUNT(*) as total')
            ->groupBy('kabupaten_kota')
            ->orderByDesc('total')
            ->pluck('total', 'kabupaten_kota');

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Keanggotaan',
                    'data' => $data->values()->all(),
                    'backgroundColor' => [
                        
                        '#0D47A1',
                        '#2196F3',
                       
                ],],
            ],
            'labels' => $data->keys()->all(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}