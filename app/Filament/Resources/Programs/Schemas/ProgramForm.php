<?php

namespace App\Filament\Resources\Programs\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProgramForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Program')
                    ->description('Informasi dasar mengenai program kemitraan')
                    ->schema([
                        TextInput::make('nama_program')
                            ->label('Nama Program')
                            ->required()
                            ->maxLength(255),

                        Select::make('jenis_program')
                            ->label('Jenis Program')
                            ->options([
                                'Pendidikan' => 'Pendidikan',
                                'Pelatihan' => 'Pelatihan',
                                'Pendampingan' => 'Pendampingan',
                                'Pengembangan Kompetensi' => 'Pengembangan Kompetensi',
                                'Pemberdayaan' => 'Pemberdayaan',
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
                            ->searchable(),

                        TextInput::make('penanggung_jawab')
                            ->label('Penanggung Jawab')
                            ->maxLength(255),

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
                    ])
                    ->columns(2),

                Section::make('Deskripsi dan Waktu')
                    ->description('Informasi detail dan periode pelaksanaan program')
                    ->schema([
                        Textarea::make('deskripsi')
                            ->label('Deskripsi Program')
                            ->rows(4)
                            ->columnSpanFull(),

                        DatePicker::make('tanggal_mulai')
                            ->label('Tanggal Mulai')
                            ->native(false)
                            ->displayFormat('d M Y'),

                        DatePicker::make('tanggal_selesai')
                            ->label('Tanggal Selesai')
                            ->native(false)
                            ->displayFormat('d M Y')
                            ->afterOrEqual('tanggal_mulai'),

                        Textarea::make('keterangan')
                            ->label('Keterangan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}