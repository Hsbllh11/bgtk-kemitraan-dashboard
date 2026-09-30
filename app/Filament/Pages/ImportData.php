<?php

namespace App\Filament\Pages;

use App\Imports\KebutuhanKepalaSekolahImport;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ImportData extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedArrowUpTray;

    protected static string|\UnitEnum|null $navigationGroup =
        'MENU UTAMA';

    protected static ?string $navigationLabel =
        'Import Data';

    protected static ?int $navigationSort = 6;

    protected static ?string $title =
        'Import Data';

    protected string $view =
        'filament.pages.import-data';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
            ->statePath('data');
    }

    public function import(): void
    {
        try {
            // Ambil state form setelah form diinisialisasi
            $data = $this->form->getState();

            $kabupatenKota = $data['kabupaten_kota'] ?? null;
            $file = $data['file'] ?? null;

            if (blank($kabupatenKota)) {
                Notification::make()
                    ->title('Kabupaten / Kota belum dipilih')
                    ->body('Silakan pilih kabupaten/kota terlebih dahulu.')
                    ->danger()
                    ->send();

                return;
            }

            if (blank($file)) {
                Notification::make()
                    ->title('File belum dipilih')
                    ->body('Silakan pilih file Excel atau CSV terlebih dahulu.')
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

            $this->form->fill();

        } catch (\Throwable $e) {

            Notification::make()
                ->title('Import gagal')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}