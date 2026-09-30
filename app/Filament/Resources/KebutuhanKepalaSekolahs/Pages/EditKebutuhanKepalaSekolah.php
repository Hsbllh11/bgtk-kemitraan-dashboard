<?php

namespace App\Filament\Resources\KebutuhanKepalaSekolahs\Pages;

use App\Filament\Resources\KebutuhanKepalaSekolahs\KebutuhanKepalaSekolahResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKebutuhanKepalaSekolah extends EditRecord
{
    protected static string $resource = KebutuhanKepalaSekolahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
