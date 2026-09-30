<?php

namespace App\Filament\Resources\Programs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProgramsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_program')
                    ->label('Nama Program')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('jenis_program')
                    ->label('Jenis Program')
                    ->badge()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('kabupaten_kota')
                    ->label('Kabupaten / Kota')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tanggal_mulai')
                    ->label('Tanggal Mulai')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('tanggal_selesai')
                    ->label('Tanggal Selesai')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('penanggung_jawab')
                    ->label('Penanggung Jawab')
                    ->searchable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Direncanakan' => 'warning',
                        'Berlangsung' => 'info',
                        'Selesai' => 'success',
                        'Dibatalkan' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'Direncanakan' => 'Direncanakan',
                        'Berlangsung' => 'Berlangsung',
                        'Selesai' => 'Selesai',
                        'Dibatalkan' => 'Dibatalkan',
                    ]),

                SelectFilter::make('jenis_program')
                    ->label('Jenis Program')
                    ->options([
                        'Pendidikan' => 'Pendidikan',
                        'Pelatihan' => 'Pelatihan',
                        'Pendampingan' => 'Pendampingan',
                        'Pengembangan Kompetensi' => 'Pengembangan Kompetensi',
                        'Pemberdayaan' => 'Pemberdayaan',
                        'Lainnya' => 'Lainnya',
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