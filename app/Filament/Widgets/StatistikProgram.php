<?php

namespace App\Filament\Widgets;

use App\Models\Program;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatistikProgram extends StatsOverviewWidget
{
    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $totalProgram = Program::count();

        $programBerlangsung = Program::where('status', 'Berlangsung')->count();

        $programSelesai = Program::where('status', 'Selesai')->count();

        return [
            Stat::make('Total Program', $totalProgram)
                ->description('Seluruh program yang terdata')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('primary'),

            Stat::make('Program Berlangsung', $programBerlangsung)
                ->description('Program yang sedang berjalan')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Program Selesai', $programSelesai)
                ->description('Program yang telah selesai')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
        ];
    }
}