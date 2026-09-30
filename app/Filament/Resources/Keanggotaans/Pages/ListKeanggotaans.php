<?php

namespace App\Filament\Resources\Keanggotaans\Pages;

use App\Filament\Resources\Keanggotaans\KeanggotaanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKeanggotaans extends ListRecords
{
    protected static string $resource = KeanggotaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
