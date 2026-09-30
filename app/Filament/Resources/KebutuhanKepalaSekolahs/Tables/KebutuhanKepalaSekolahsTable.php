<?php

namespace App\Filament\Resources\KebutuhanKepalaSekolahs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class KebutuhanKepalaSekolahsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tahun')
                    ->label('Tahun')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('kabupaten_kota')
                    ->label('Kabupaten / Kota')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nama_sekolah')
                    ->label('Nama Sekolah')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('nama_kepala_sekolah')
                    ->label('Nama Kepala Sekolah')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->placeholder('-'),

                TextColumn::make('lokasi_sekolah')
                    ->label('Lokasi Sekolah')
                    ->searchable()
                    ->wrap()
                    ->toggleable(),

                TextColumn::make('usia')
                    ->label('Usia')
                    ->numeric()
                    ->sortable()
                    ->alignCenter()
                    ->placeholder('-'),

                TextColumn::make('status_ks')
                    ->label('Status KS')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'Kepala Sekolah' => 'success',
                        'PLT Kepala Sekolah' => 'warning',
                        default => 'gray',
                    })
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('status_sekolah')
                    ->label('Status Sekolah')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'Negeri' => 'info',
                        'Swasta' => 'warning',
                        default => 'gray',
                    })
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('tanggal_pensiun')
                    ->label('Tanggal Pensiun')
                    ->date('d-m-Y')
                    ->sortable()
                    ->placeholder('-')
                    ->toggleable(),

                TextColumn::make('akhir_periode')
                    ->label('Akhir Periode')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-')
                    ->toggleable(),

                TextColumn::make('periode_penugasan')
                    ->label('Periode Penugasan')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-')
                    ->toggleable(),

                TextColumn::make('pemetaan')
                    ->label('Pemetaan')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'VALID_MAPPING' => 'success',
                        'UNMAPPED' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
            ])

            ->filters([
                SelectFilter::make('kabupaten_kota')
                    ->label('Kabupaten / Kota')
                    ->options([
                        'Kota Bima' => 'Kota Bima',
                        'Kabupaten Bima' => 'Kabupaten Bima',
                        'Dompu' => 'Dompu',
                        'Kabupaten Sumbawa' => 'Kabupaten Sumbawa',
                        'Sumbawa Barat' => 'Sumbawa Barat',
                        'Lombok Timur' => 'Lombok Timur',
                        'Lombok Tengah' => 'Lombok Tengah',
                        'Lombok Barat' => 'Lombok Barat',
                        'Lombok Utara' => 'Lombok Utara',
                        'Kota Mataram' => 'Kota Mataram',
                    ])
                    ->searchable(),

                SelectFilter::make('status_ks')
                    ->label('Status KS')
                    ->options([
                        'Kepala Sekolah' => 'Kepala Sekolah',
                        'PLT Kepala Sekolah' => 'PLT Kepala Sekolah',
                    ]),

                SelectFilter::make('status_sekolah')
                    ->label('Status Sekolah')
                    ->options([
                        'Negeri' => 'Negeri',
                        'Swasta' => 'Swasta',
                    ]),

                SelectFilter::make('pemetaan')
                    ->label('Pemetaan')
                    ->options([
                        'VALID_MAPPING' => 'Valid Mapping',
                        'UNMAPPED' => 'Unmapped',
                    ]),
            ])

            ->recordActions([
                EditAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}