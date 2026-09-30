<?php

namespace App\Filament\Resources\KebutuhanKepalaSekolahs\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KebutuhanKepalaSekolahForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('tahun')
                    ->label('Tahun')
                    ->options([
                        2026 => '2026',
                        2027 => '2027',
                        2028 => '2028',
                    ])
                    ->default(2026)
                    ->required(),

                Select::make('kabupaten_kota')
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
                    ->searchable()
                    ->required(),

                TextInput::make('nama_sekolah')
                    ->label('Nama Sekolah')
                    ->required()
                    ->maxLength(255),

                TextInput::make('nama_kepala_sekolah')
                    ->label('Nama Kepala Sekolah')
                    ->maxLength(255),

                TextInput::make('lokasi_sekolah')
                    ->label('Lokasi Sekolah')
                    ->maxLength(255),

                TextInput::make('usia')
                    ->label('Usia')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100),

                Select::make('status_ks')
                    ->label('Status KS')
                    ->options([
                        'Kepala Sekolah' => 'Kepala Sekolah',
                        'PLT Kepala Sekolah' => 'PLT Kepala Sekolah',
                    ])
                    ->searchable(),

                Select::make('status_sekolah')
                    ->label('Status Sekolah')
                    ->options([
                        'Negeri' => 'Negeri',
                        'Swasta' => 'Swasta',
                    ]),

                DatePicker::make('tanggal_pensiun')
                    ->label('Tanggal Pensiun')
                    ->displayFormat('d-m-Y')
                    ->native(false),

                TextInput::make('akhir_periode')
                    ->label('Akhir Periode')
                    ->maxLength(255),

                TextInput::make('periode_penugasan')
                    ->label('Periode Penugasan')
                    ->maxLength(255),

                Select::make('pemetaan')
                    ->label('Pemetaan')
                    ->options([
                        'VALID_MAPPING' => 'Valid Mapping',
                        'UNMAPPED' => 'Unmapped',
                    ]),
            ]);
    }
}