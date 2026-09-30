<?php

namespace App\Filament\Resources\KebutuhanKepalaSekolahs;

use App\Filament\Resources\KebutuhanKepalaSekolahs\Pages\CreateKebutuhanKepalaSekolah;
use App\Filament\Resources\KebutuhanKepalaSekolahs\Pages\EditKebutuhanKepalaSekolah;
use App\Filament\Resources\KebutuhanKepalaSekolahs\Pages\ListKebutuhanKepalaSekolahs;
use App\Filament\Resources\KebutuhanKepalaSekolahs\Schemas\KebutuhanKepalaSekolahForm;
use App\Filament\Resources\KebutuhanKepalaSekolahs\Tables\KebutuhanKepalaSekolahsTable;
use App\Models\KebutuhanKepalaSekolah;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KebutuhanKepalaSekolahResource extends Resource
{
    protected static ?string $model = KebutuhanKepalaSekolah::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHomeModern;

    protected static ?string $recordTitleAttribute = 'nama_sekolah';

    public static function form(Schema $schema): Schema
    {
        return KebutuhanKepalaSekolahForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KebutuhanKepalaSekolahsTable::configure($table);
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
            'index' => ListKebutuhanKepalaSekolahs::route('/'),
            'create' => CreateKebutuhanKepalaSekolah::route('/create'),
            'edit' => EditKebutuhanKepalaSekolah::route('/{record}/edit'),
        ];
    }
}
