<?php

namespace App\Filament\Resources\Mitras\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MitraForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Mitra')
                    ->description('Informasi dasar mengenai mitra')
                    ->schema([
                        TextInput::make('nama_mitra')
                            ->label('Nama Mitra')
                            ->required()
                            ->maxLength(255),

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

                        TextInput::make('instansi')
                            ->label('Instansi')
                            ->maxLength(255),

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

                        TextInput::make('kontak')
                            ->label('Nomor Kontak')
                            ->tel()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Detail Mitra')
                    ->description('Informasi alamat dan status kemitraan')
                    ->schema([
                        Textarea::make('alamat')
                            ->label('Alamat')
                            ->rows(3)
                            ->columnSpanFull(),

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
                            ->displayFormat('d M Y'),

                        Textarea::make('keterangan')
                            ->label('Keterangan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}