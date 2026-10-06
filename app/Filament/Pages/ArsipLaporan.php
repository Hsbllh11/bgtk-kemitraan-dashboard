<?php

namespace App\Filament\Pages;

use App\Models\LaporanFile;
use App\Models\LaporanFolder;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Url;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ArsipLaporan extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFolderOpen;

    protected static string|\UnitEnum|null $navigationGroup = 'LAINNYA';

    protected static ?string $navigationLabel = 'Arsip Laporan';

    protected static ?string $title = 'Arsip Laporan';

    protected static ?string $slug = 'arsip-laporan';

    protected string $view = 'filament.pages.arsip-laporan';

    #[Url]
    public ?int $folderId = null;

    public string $viewMode = 'grid';

    public string $search = '';

    public ?int $previewId = null;

    /* ---------------- Navigasi ---------------- */

    public function openFolder(?int $id = null): void
    {
        $this->folderId = $id;
    }

    public function getCurrentFolder(): ?LaporanFolder
    {
        return $this->folderId ? LaporanFolder::find($this->folderId) : null;
    }

    public function getBreadcrumbTrail(): array
    {
        return $this->getCurrentFolder()?->breadcrumbs() ?? [];
    }

    public function getFolders()
    {
        return LaporanFolder::query()
            ->where('parent_id', $this->folderId)
            ->when($this->search !== '', fn ($q) => $q->where('nama', 'like', '%' . $this->search . '%'))
            ->withCount(['children', 'files'])
            ->orderBy('nama')
            ->get();
    }

    public function getFiles()
    {
        return LaporanFile::query()
            ->with('uploader')
            ->where('folder_id', $this->folderId)
            ->when($this->search !== '', fn ($q) => $q->where('nama', 'like', '%' . $this->search . '%'))
            ->latest()
            ->get();
    }

    /* ---------------- Preview ---------------- */

    public function openPreview(int $id): void
    {
        $this->previewId = $id;
    }

    public function closePreview(): void
    {
        $this->previewId = null;
    }

    public function getPreviewFile(): ?LaporanFile
    {
        return $this->previewId ? LaporanFile::find($this->previewId) : null;
    }

    /* ---------------- Header Actions ---------------- */

    protected function getHeaderActions(): array
    {
        return [
            $this->createFolderAction(),
            $this->uploadFileAction(),
        ];
    }

    public function createFolderAction(): Action
    {
        return Action::make('createFolder')
            ->label('Folder Baru')
            ->icon(Heroicon::OutlinedFolderPlus)
            ->color('gray')
            ->modalHeading('Buat Folder Baru')
            ->modalSubmitActionLabel('Buat')
            ->schema([
                TextInput::make('nama')
                    ->label('Nama Folder')
                    ->required()
                    ->maxLength(255)
                    ->rules([
                        fn () => Rule::unique('laporan_folders', 'nama')
                            ->where('parent_id', $this->folderId),
                    ])
                    ->validationMessages([
                        'unique' => 'Nama folder sudah ada di lokasi ini.',
                    ]),
            ])
            ->action(function (array $data): void {
                LaporanFolder::create([
                    'parent_id' => $this->folderId,
                    'nama' => trim($data['nama']),
                    'created_by' => auth()->id(),
                ]);

                Notification::make()
                    ->title('Folder berhasil dibuat')
                    ->success()
                    ->send();
            });
    }

    public function uploadFileAction(): Action
    {
        return Action::make('uploadFile')
            ->label('Upload File')
            ->icon(Heroicon::OutlinedArrowUpTray)
            ->modalHeading('Upload File')
            ->modalSubmitActionLabel('Upload')
            ->schema([
                FileUpload::make('files')
                    ->label('File')
                    ->multiple()
                    ->required()
                    ->disk('local')
                    ->directory('arsip-laporan')
                    ->maxSize(20480) // 20 MB
                    ->maxFiles(10)
                    ->acceptedFileTypes([
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'application/vnd.ms-powerpoint',
                        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                        'text/csv',
                        'image/jpeg',
                        'image/png',
                    ])
                    // Prefix UUID agar nama tidak bentrok; nama asli disimpan di DB
                    ->getUploadedFileNameForStorageUsing(
                        fn (TemporaryUploadedFile $file): string =>
                            Str::uuid() . '_' . $file->getClientOriginalName()
                    )
                    ->helperText('Maksimal 10 file, masing-masing 20 MB.'),
            ])
            ->action(function (array $data): void {
                $disk = Storage::disk('local');

                foreach ($data['files'] as $path) {
                    $basename = basename($path);

                    LaporanFile::create([
                        'folder_id' => $this->folderId,
                        'nama' => Str::after($basename, '_'),
                        'path' => $path,
                        'mime_type' => $disk->mimeType($path),
                        'ukuran' => $disk->size($path),
                        'uploaded_by' => auth()->id(),
                    ]);
                }

                Notification::make()
                    ->title(count($data['files']) . ' file berhasil diupload')
                    ->success()
                    ->send();
            });
    }

    /* ---------------- Row Actions ---------------- */

    public function deleteFolderAction(): Action
    {
        return Action::make('deleteFolder')
            ->label('Hapus')
            ->icon(Heroicon::OutlinedTrash)
            ->color('danger')
            ->iconButton()
            ->requiresConfirmation()
            ->modalHeading('Hapus folder?')
            ->modalDescription('Semua subfolder dan file di dalamnya akan ikut terhapus permanen.')
            ->action(function (array $arguments): void {
                LaporanFolder::find($arguments['id'])?->deleteTree();

                Notification::make()->title('Folder dihapus')->success()->send();
            });
    }

    public function deleteFileAction(): Action
    {
        return Action::make('deleteFile')
            ->label('Hapus')
            ->icon(Heroicon::OutlinedTrash)
            ->color('danger')
            ->iconButton()
            ->requiresConfirmation()
            ->modalHeading('Hapus file?')
            ->action(function (array $arguments): void {
                $file = LaporanFile::find($arguments['id']);

                if ($file) {
                    Storage::disk('local')->delete($file->path);
                    $file->delete();
                }

                Notification::make()->title('File dihapus')->success()->send();
            });
    }

    public function downloadFileAction(): Action
    {
        return Action::make('downloadFile')
            ->label('Download')
            ->icon(Heroicon::OutlinedArrowDownTray)
            ->iconButton()
            ->action(function (array $arguments) {
                $file = LaporanFile::findOrFail($arguments['id']);

                return Storage::disk('local')->download($file->path, $file->nama);
            });
    }
}