<?php

namespace App\Filament\Resources\Keanggotaans;

use App\Filament\Resources\Keanggotaans\Pages\CreateKeanggotaan;
use App\Filament\Resources\Keanggotaans\Pages\EditKeanggotaan;
use App\Filament\Resources\Keanggotaans\Pages\ListKeanggotaans;
use App\Filament\Resources\Keanggotaans\Schemas\KeanggotaanForm;
use App\Filament\Resources\Keanggotaans\Tables\KeanggotaansTable;
use App\Models\Keanggotaan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KeanggotaanResource extends Resource
{
    protected static ?string $model = Keanggotaan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $recordTitleAttribute = 'nama';

    protected static ?string $navigationLabel = 'Data Keanggotaan';

    protected static string|\UnitEnum|null $navigationGroup = 'MENU UTAMA';

    protected static ?string $modelLabel = 'Keanggotaan';

    protected static ?string $pluralModelLabel = 'Data Keanggotaan';

    public static function form(Schema $schema): Schema
    {
        return KeanggotaanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KeanggotaansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKeanggotaans::route('/'),
            'create' => CreateKeanggotaan::route('/create'),
            'edit' => EditKeanggotaan::route('/{record}/edit'),
        ];
    }
}
