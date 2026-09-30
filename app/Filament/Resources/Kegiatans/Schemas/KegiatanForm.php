<?php

namespace App\Filament\Resources\Kegiatans\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KegiatanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kegiatan')
                    ->description('Informasi dasar mengenai kegiatan kemitraan')
                    ->schema([
                        TextInput::make('nama_kegiatan')
                            ->label('Nama Kegiatan')
                            ->required()
                            ->maxLength(255),

                        Select::make('jenis_kegiatan')
                            ->label('Jenis Kegiatan')
                            ->options([
                                'Pelatihan' => 'Pelatihan',
                                'Workshop' => 'Workshop',
                                'Seminar' => 'Seminar',
                                'Pendampingan' => 'Pendampingan',
                                'Sosialisasi' => 'Sosialisasi',
                                'Rapat' => 'Rapat',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->required()
                            ->searchable(),

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

                        TextInput::make('lokasi')
                            ->label('Lokasi')
                            ->maxLength(255),

                        TextInput::make('penanggung_jawab')
                            ->label('Penanggung Jawab')
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Waktu dan Status')
                    ->description('Informasi waktu pelaksanaan dan status kegiatan')
                    ->schema([
                        DatePicker::make('tanggal_mulai')
                            ->label('Tanggal Mulai')
                            ->native(false)
                            ->displayFormat('d M Y')
                            ->required(),

                        DatePicker::make('tanggal_selesai')
                            ->label('Tanggal Selesai')
                            ->native(false)
                            ->displayFormat('d M Y')
                            ->afterOrEqual('tanggal_mulai'),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'Direncanakan' => 'Direncanakan',
                                'Berlangsung' => 'Berlangsung',
                                'Selesai' => 'Selesai',
                                'Dibatalkan' => 'Dibatalkan',
                            ])
                            ->default('Direncanakan')
                            ->required(),

                        Textarea::make('keterangan')
                            ->label('Keterangan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}