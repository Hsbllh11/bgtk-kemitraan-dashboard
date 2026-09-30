<?php

namespace App\Filament\Widgets;

use App\Models\Kegiatan;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatistikKegiatan extends StatsOverviewWidget
{
    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $totalKegiatan = Kegiatan::count();

        $kegiatanBerlangsung = Kegiatan::where('status', 'Berlangsung')->count();

        $kegiatanSelesai = Kegiatan::where('status', 'Selesai')->count();

        return [
            Stat::make('Total Kegiatan', $totalKegiatan)
                ->description('Seluruh kegiatan yang terdata')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('primary'),

            Stat::make('Sedang Berlangsung', $kegiatanBerlangsung)
                ->description('Kegiatan yang sedang berjalan')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Kegiatan Selesai', $kegiatanSelesai)
                ->description('Kegiatan yang telah selesai')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
        ];
    }
}