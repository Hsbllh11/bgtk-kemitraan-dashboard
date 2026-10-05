<?php

namespace App\Filament\Resources\Programs\Pages;

use App\Filament\Resources\Programs\ProgramResource;
use App\Imports\ProgramImport;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ListPrograms extends ListRecords
{
    protected static string $resource = ProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('import')
                ->label('Import Data')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('gray')
                ->schema([
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
                ->modalHeading('Import Data Program')
                ->modalDescription(
                    'Import data program BGTK dari file Excel atau CSV.'
                )
                ->modalSubmitActionLabel('Import Data')
                ->action(function (array $data): void {
                    try {
                        $file = $data['file'] ?? null;

                        if (blank($file)) {
                            Notification::make()
                                ->title('File belum dipilih')
                                ->body(
                                    'Silakan pilih file Excel atau CSV terlebih dahulu.'
                                )
                                ->danger()
                                ->send();

                            return;
                        }

                        $filePath = Storage::disk('local')->path($file);

                        if (! file_exists($filePath)) {
                            Notification::make()
                                ->title('File tidak ditemukan')
                                ->body(
                                    'File upload tidak ditemukan di penyimpanan server.'
                                )
                                ->danger()
                                ->send();

                            return;
                        }

                        Excel::import(
                            new ProgramImport(),
                            $filePath
                        );

                        Notification::make()
                            ->title('Import berhasil')
                            ->body(
                                'Data program berhasil dimasukkan ke database.'
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