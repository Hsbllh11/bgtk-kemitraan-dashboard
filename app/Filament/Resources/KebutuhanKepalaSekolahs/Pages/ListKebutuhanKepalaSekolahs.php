<?php

namespace App\Filament\Resources\KebutuhanKepalaSekolahs\Pages;

use App\Filament\Resources\KebutuhanKepalaSekolahs\KebutuhanKepalaSekolahResource;
use App\Imports\KebutuhanKepalaSekolahImport;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ListKebutuhanKepalaSekolahs extends ListRecords
{
    protected static string $resource = KebutuhanKepalaSekolahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('import')
                ->label('Import Data')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('gray')
                ->schema([
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

                    FileUpload::make('file')
                        ->label('File Excel / CSV')
                        ->acceptedFileTypes([
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel',
                            'text/csv',
                            'text/plain',
                        ])
                        ->disk('local')
                        ->directory('imports')
                        ->required()
                        ->maxSize(10240)
                        ->helperText(
                            'Gunakan file .xlsx, .xls, atau .csv dengan format kolom yang sesuai.'
                        ),
                ])
                ->modalHeading('Import Data Sekolah')
                ->modalDescription(
                    'Import data kebutuhan kepala sekolah berdasarkan kabupaten/kota.'
                )
                ->modalSubmitActionLabel('Import Data')
                ->action(function (array $data): void {
                    try {
                        $kabupatenKota = $data['kabupaten_kota'] ?? null;
                        $file = $data['file'] ?? null;

                        if (blank($kabupatenKota) || blank($file)) {
                            Notification::make()
                                ->title('Data import belum lengkap')
                                ->body('Kabupaten/kota dan file wajib dipilih.')
                                ->danger()
                                ->send();

                            return;
                        }

                        $filePath = Storage::disk('local')->path($file);

                        if (! file_exists($filePath)) {
                            Notification::make()
                                ->title('File tidak ditemukan')
                                ->body('File upload tidak ditemukan di penyimpanan server.')
                                ->danger()
                                ->send();

                            return;
                        }

                        Excel::import(
                            new KebutuhanKepalaSekolahImport(
                                $kabupatenKota,
                                2026
                            ),
                            $filePath
                        );

                        Notification::make()
                            ->title('Import berhasil')
                            ->body(
                                'Data ' . $kabupatenKota .
                                ' berhasil dimasukkan ke database.'
                            )
                            ->success()
                            ->send();

                    } catch (\Throwable $e) {
                        Notification::make()
                            ->title('Import gagal')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),

            CreateAction::make(),
        ];
    }
}
