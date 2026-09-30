<?php

namespace App\Filament\Widgets;

use App\Models\Mitra;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatistikMitra extends StatsOverviewWidget
{
    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $totalMitra = Mitra::count();

        $mitraAktif = Mitra::where('status', 'Aktif')->count();

        $jumlahJenisMitra = Mitra::query()
            ->distinct('jenis_mitra')
            ->count('jenis_mitra');

        return [
            Stat::make('Total Mitra', $totalMitra)
                ->description('Seluruh data mitra')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Mitra Aktif', $mitraAktif)
                ->description('Mitra dengan status aktif')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Jenis Mitra', $jumlahJenisMitra)
                ->description('Jenis mitra yang terdata')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('warning'),
        ];
    }
}