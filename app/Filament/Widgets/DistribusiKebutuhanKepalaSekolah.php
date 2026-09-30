<?php

namespace App\Filament\Widgets;

use App\Models\KebutuhanKepalaSekolah;
use Filament\Widgets\ChartWidget;

class DistribusiKebutuhanKepalaSekolah extends ChartWidget
{
    protected ?string $heading = 'Distribusi Kebutuhan Kepala Sekolah';

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $data = KebutuhanKepalaSekolah::query()
            ->selectRaw('kabupaten_kota, COUNT(*) as total')
            ->groupBy('kabupaten_kota')
            ->orderBy('kabupaten_kota')
            ->get();

        return [
            'labels' => $data->pluck('kabupaten_kota')->toArray(),

            'datasets' => [
                [
                    'label' => 'Jumlah Sekolah',
                    'data' => $data->pluck('total')->map(fn ($total) => (int) $total)->toArray(),
                    'backgroundColor' => ['#FF9D50', '#FFF9D8'],
                    // 'borderColor' => '#1d4ed8',
                    // 'borderWidth' => 1,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,

            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],

            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
            ],
        ];
    }
}