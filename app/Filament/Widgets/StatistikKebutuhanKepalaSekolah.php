<?php

namespace App\Filament\Widgets;

use App\Models\KebutuhanKepalaSekolah;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatistikKebutuhanKepalaSekolah extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $total = KebutuhanKepalaSekolah::count();

        $kepalaSekolah = KebutuhanKepalaSekolah::where(
            'status_ks',
            'Kepala Sekolah'
        )->count();

        $pltKepalaSekolah = KebutuhanKepalaSekolah::where(
            'status_ks',
            'PLT Kepala Sekolah'
        )->count();

        $validMapping = KebutuhanKepalaSekolah::where(
            'pemetaan',
            'VALID_MAPPING'
        )->count();

        $unmapped = KebutuhanKepalaSekolah::where(
            'pemetaan',
            'UNMAPPED'
        )->count();

        return [
            Stat::make(
                'Total Sekolah',
                number_format($total, 0, ',', '.')
            )
                ->description('Total data sekolah')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('primary'),

            Stat::make(
                'Kepala Sekolah',
                number_format($kepalaSekolah, 0, ',', '.')
            )
                ->description('Status Kepala Sekolah')
                ->descriptionIcon('heroicon-m-user')
                ->color('success'),

            Stat::make(
                'PLT Kepala Sekolah',
                number_format($pltKepalaSekolah, 0, ',', '.')
            )
                ->description('Status PLT Kepala Sekolah')
                ->descriptionIcon('heroicon-m-user')
                ->color('warning'),

            Stat::make(
                'Valid Mapping',
                number_format($validMapping, 0, ',', '.')
            )
                ->description('Data dengan pemetaan valid')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make(
                'Unmapped',
                number_format($unmapped, 0, ',', '.')
            )
                ->description('Data belum memiliki pemetaan')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),
        ];
    }

    protected function getColumns(): int
    {
        return 5;
    }
}
