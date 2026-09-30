<?php

namespace App\Filament\Widgets;

use App\Models\keanggotaan;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatistikKeanggotaan extends StatsOverviewWidget
{
    protected int|string|array $columnSpan = 'full';
    protected function getStats(): array
    {
        $totalKeanggotaan = keanggotaan::count();

        $keanggotaanAktif = keanggotaan::where('status', 'Aktif')->count();

        $jumlahKabupatenKota = keanggotaan::query()
            ->distinct('kabupaten_kota')
            ->count('kabupaten_kota');

        return [
            Stat::make('Total Keanggotaan', $totalKeanggotaan)
                ->description('Seluruh data keanggotaan')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Keanggotaan Aktif', $keanggotaanAktif)
                ->description('Anggota dengan status aktif')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Kabupaten / Kota', $jumlahKabupatenKota)
                ->description('Wilayah yang terdata')
                ->descriptionIcon('heroicon-m-map-pin')
                ->color('warning'),
        ];
    }
}