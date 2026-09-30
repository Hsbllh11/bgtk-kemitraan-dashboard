<?php

namespace App\Filament\Resources\Keanggotaans\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KeanggotaanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Identitas')
                    ->description('Informasi dasar anggota kemitraan')
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('nip_nik')
                            ->label('NIP / NIK')
                            ->maxLength(255),

                        TextInput::make('instansi')
                            ->label('Instansi')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('jabatan')
                            ->label('Jabatan')
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Data Kemitraan')
                    ->description('Informasi mengenai status dan peran dalam kemitraan')
                    ->schema([
                        Select::make('kabupaten_kota')
                            ->label('Kabupaten / Kota')
                            ->options([
                                'Kota Mataram' => 'Kota Mataram',
                                'Kabupaten Lombok Barat' => 'Kabupaten Lombok Barat',
                                'Kabupaten Lombok Tengah' => 'Kabupaten Lombok Tengah',
                                'Kabupaten Lombok Timur' => 'Kabupaten Lombok Timur',
                                'Kabupaten Lombok Utara' => 'Kabupaten Lombok Utara',
                                'Kabupaten Sumbawa' => 'Kabupaten Sumbawa',
                                'Kabupaten Sumbawa Barat' => 'Kabupaten Sumbawa Barat',
                                'Kabupaten Dompu' => 'Kabupaten Dompu',
                                'Kabupaten Bima' => 'Kabupaten Bima',
                                'Kota Bima' => 'Kota Bima',
                            ])
                            ->required()
                            ->searchable(),

                        Select::make('jenis_mitra')
                            ->label('Jenis Mitra')
                            ->options([
                                'Pemerintah' => 'Pemerintah',
                                'Satuan Pendidikan' => 'Satuan Pendidikan',
                                'Perguruan Tinggi' => 'Perguruan Tinggi',
                                'Organisasi' => 'Organisasi',
                                'Komunitas' => 'Komunitas',
                                'Individu' => 'Individu',
                            ])
                            ->required()
                            ->searchable(),

                        Select::make('peran')
                            ->label('Peran')
                            ->options([
                                'Anggota' => 'Anggota',
                                'Koordinator' => 'Koordinator',
                                'Narasumber' => 'Narasumber',
                                'Fasilitator' => 'Fasilitator',
                                'Mitra' => 'Mitra',
                            ])
                            ->required()
                            ->searchable(),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'Aktif' => 'Aktif',
                                'Nonaktif' => 'Nonaktif',
                            ])
                            ->default('Aktif')
                            ->required(),

                        DatePicker::make('tanggal_bergabung')
                            ->label('Tanggal Bergabung')
                            ->native(false)
                            ->displayFormat('d M Y')
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }
}