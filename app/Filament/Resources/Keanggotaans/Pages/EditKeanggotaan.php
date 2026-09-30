<?php

namespace App\Filament\Resources\Keanggotaans\Pages;

use App\Filament\Resources\Keanggotaans\KeanggotaanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKeanggotaan extends EditRecord
{
    protected static string $resource = KeanggotaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
