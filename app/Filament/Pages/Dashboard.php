<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DistribusiKeanggotaan;
use App\Filament\Widgets\DistribusiKebutuhanKepalaSekolah;
use App\Filament\Widgets\StatistikKeanggotaan;
use App\Filament\Widgets\StatistikKegiatan;
use App\Filament\Widgets\StatistikKebutuhanKepalaSekolah;
use App\Filament\Widgets\StatistikMitra;
use App\Filament\Widgets\StatistikProgram;
use App\Filament\Widgets\StatusKeanggotaan;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected function getHeaderWidgets(): array
    {
        return [
            StatistikKeanggotaan::class,
            StatistikMitra::class,
            StatistikKegiatan::class,
            StatistikProgram::class,
            StatistikKebutuhanKepalaSekolah::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            DistribusiKeanggotaan::class,
            StatusKeanggotaan::class,
            DistribusiKebutuhanKepalaSekolah::class,
        ];
    }
}