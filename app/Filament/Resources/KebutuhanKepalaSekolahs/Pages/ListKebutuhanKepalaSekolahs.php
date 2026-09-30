<?php

namespace App\Filament\Resources\KebutuhanKepalaSekolahs\Pages;

use App\Filament\Resources\KebutuhanKepalaSekolahs\KebutuhanKepalaSekolahResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKebutuhanKepalaSekolahs extends ListRecords
{
    protected static string $resource = KebutuhanKepalaSekolahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
