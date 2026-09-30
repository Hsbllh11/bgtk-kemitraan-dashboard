<?php

namespace App\Filament\Resources\Keanggotaans\Tables;

use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KeanggotaansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nip_nik')
                    ->label('NIP / NIK')
                    ->searchable(),

                TextColumn::make('instansi')
                    ->label('Instansi')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('kabupaten_kota')
                    ->label('Kabupaten / Kota')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('jenis_mitra')
                    ->label('Jenis Mitra')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('peran')
                    ->label('Peran')
                    ->searchable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Aktif' => 'success',
                        'Nonaktif' => 'gray',
                        default => 'warning',
                    })
                    ->sortable(),

                TextColumn::make('tanggal_bergabung')
                    ->label('Tanggal Bergabung')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                     ->label('Status')
                        ->options([
            'Aktif' => 'Aktif',
            'Nonaktif' => 'Nonaktif',
        ]),
])
            ->recordActions([
                EditAction::make()
                    ->label('Edit'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}