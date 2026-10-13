<?php

namespace App\Filament\Pages;

use App\Models\LaporanFile;
use App\Models\LaporanFolder;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
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

    public string $viewMode = 'list';
    public string $search = '';
    public string $sortBy = 'nama';      // nama | tanggal | ukuran
    public string $sortDir = 'asc';
    public string $filterJenis = '';     // '', folder, pdf, word, excel, ppt, image

    public array $pendingMove = [];

    public array $pendingCopy = [];

    public array $pendingDelete = [];

    public ?int $previewId = null;

    public $uploads = [];

    protected const EKSTENSI_DIIZINKAN = [
        'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx',
        'csv', 'jpg', 'jpeg', 'png', 'gif', 'webp', 'odt', 'ods', 'odp', 'rtf', 'txt',
        'mp4', 'mkv', 'mov', 'avi', 'mp3', 'wav',
        'seb', 'exe', 'zip', 'rar', '7z',
    ];

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

    /* ---------------- Sorting ---------------- */

    public function urutkan(string $by): void
    {
        if ($this->sortBy === $by) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
            return;
        }

        $this->sortBy = $by;
        $this->sortDir = 'asc';
    }

    /* ---------------- Data ---------------- */

    public function getFolders()
    {
        if (! in_array($this->filterJenis, ['', 'folder'], true)) {
            return collect();
        }

        $folders = LaporanFolder::query()
            ->with('creator')
            ->where('parent_id', $this->folderId)
            ->when($this->search !== '', fn ($q) => $q->where('nama', 'like', '%' . $this->search . '%'))
            ->withCount(['children', 'files'])
            ->get();

        // Folder tidak punya ukuran, jadi urut berdasarkan nama bila yang dipilih "ukuran"
        $by = $this->sortBy === 'tanggal' ? 'tanggal' : 'nama';

        return $this->urutAlami($folders, $by);
    }

    public function getFiles()
    {
        if ($this->filterJenis === 'folder') {
            return collect();
        }

        $files = LaporanFile::query()
            ->with('uploader')
            ->where('folder_id', $this->folderId)
            ->when($this->search !== '', fn ($q) => $q->where('nama', 'like', '%' . $this->search . '%'))
            ->get();

        if ($this->filterJenis !== '') {
            $files = $files->filter(fn ($f) => $f->tipe === $this->filterJenis);
        }

        return $this->urutAlami($files, $this->sortBy);
    }

    /** Natural sort: "2." datang sebelum "10." */
    protected function urutAlami($items, string $by)
    {
        $desc = $this->sortDir === 'desc';

        $sorted = match ($by) {
            'tanggal' => $items->sortBy(fn ($i) => $i->updated_at->timestamp, SORT_REGULAR, $desc),
            'ukuran'  => $items->sortBy(fn ($i) => $i->ukuran, SORT_REGULAR, $desc),
            default   => $items->sortBy(fn ($i) => $i->nama, SORT_NATURAL | SORT_FLAG_CASE, $desc),
        };

        return $sorted->values();
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

    /* ---------------- Pindah / Move ---------------- */

    /** Dipanggil dari menu / bar "dipilih": membuka modal pemilih folder. */
    public function pindahkan(array $items): void
    {
        $this->pendingMove = $this->bersihkanItems($items);

        if ($this->pendingMove === []) {
            return;
        }

        $this->mountAction('move');
    }

    /**
     * Memindahkan item. Dipanggil dari drag & drop maupun modal.
     * $items berformat ["folder:5", "file:12"], $targetId null = paling atas.
     */
    public function moveItems(array $items, ?int $targetId = null): void
    {
        $items = $this->bersihkanItems($items);

        if ($items === []) {
            return;
        }

        if ($targetId !== null && ! LaporanFolder::whereKey($targetId)->exists()) {
            Notification::make()->title('Folder tujuan tidak ditemukan')->danger()->send();

            return;
        }

        // Rantai folder tujuan sampai root (mencegah folder dipindah ke dalam dirinya sendiri)
        $ancestors = [];
        $cur = $targetId;

        for ($i = 0; $cur && $i < 100; $i++) {
            $ancestors[] = (int) $cur;
            $cur = LaporanFolder::whereKey($cur)->value('parent_id');
        }

        $moved = 0;
        $skipped = 0;

        foreach ($items as $item) {
            [$type, $id] = explode(':', $item);
            $id = (int) $id;

            if ($type === 'folder') {
                $folder = LaporanFolder::find($id);

                if (! $folder || (int) $folder->parent_id === (int) $targetId) {
                    continue; // tidak ada / sudah di folder tujuan
                }

                if (in_array($id, $ancestors, true)) {
                    $skipped++; // folder dipindah ke dirinya sendiri / subfoldernya

                    continue;
                }

                $bentrok = LaporanFolder::where('parent_id', $targetId)
                    ->where('nama', $folder->nama)
                    ->exists();

                if ($bentrok) {
                    $skipped++;

                    continue;
                }

                $folder->update(['parent_id' => $targetId]);
                $moved++;
            } else {
                $file = LaporanFile::find($id);

                if (! $file || (int) $file->folder_id === (int) $targetId) {
                    continue;
                }

                $file->update(['folder_id' => $targetId]);
                $moved++;
            }
        }

        if ($moved > 0) {
            Notification::make()->title("{$moved} item dipindahkan")->success()->send();
        }

        if ($skipped > 0) {
            Notification::make()
                ->title("{$skipped} item dilewati")
                ->body('Folder tidak bisa dipindah ke dirinya sendiri/subfoldernya, atau nama folder sudah ada di tujuan.')
                ->warning()
                ->send();
        }
    }

    public function moveAction(): Action
    {
        return Action::make('move')
            ->modalHeading('Pindahkan ke')
            ->modalSubmitActionLabel('Pindahkan')
            ->schema([
                Select::make('target')
                    ->label('Folder tujuan')
                    ->options(fn () => $this->folderOptions())
                    ->searchable()
                    ->required()
                    ->default('root'),
            ])
            ->action(function (array $data): void {
                $target = $data['target'] === 'root' ? null : (int) $data['target'];

                $this->moveItems($this->pendingMove, $target);
                $this->pendingMove = [];
            });
    }

    /** Daftar folder tujuan ("2025 / Januari"), tanpa folder yang sedang dipindah beserta isinya. */
    protected function folderOptions(?array $items = null): array
    {
        $items ??= $this->pendingMove;

        $all = LaporanFolder::query()->get(['id', 'parent_id', 'nama'])->keyBy('id');

        $exclude = [];
        foreach ($items as $item) {
            [$type, $id] = explode(':', $item);

            if ($type === 'folder') {
                $exclude[(int) $id] = true;
            }
        }

        $options = [];

        foreach ($all as $folder) {
            $names = [];
            $cur = $folder;
            $skip = false;

            for ($i = 0; $cur && $i < 50; $i++) {
                if (isset($exclude[$cur->id])) {
                    $skip = true;
                    break;
                }

                array_unshift($names, $cur->nama);
                $cur = $cur->parent_id ? $all->get($cur->parent_id) : null;
            }

            if (! $skip) {
                $options[$folder->id] = implode(' / ', $names);
            }
        }

        asort($options, SORT_NATURAL | SORT_FLAG_CASE);

        return ['root' => 'Arsip Laporan (paling atas)'] + $options;
    }

    protected function bersihkanItems(array $items): array
    {
        return collect($items)
            ->filter(fn ($i) => is_string($i) && preg_match('/^(folder|file):\d+$/', $i))
            ->unique()
            ->values()
            ->all();
    }

    /* ---------------- Salin / Copy ---------------- */

    /** Membuka modal "Salin ke...". */
    public function salin(array $items): void
    {
        $this->pendingCopy = $this->bersihkanItems($items);

        if ($this->pendingCopy === []) {
            return;
        }

        $this->mountAction('copy');
    }

    public function copyAction(): Action
    {
        return Action::make('copy')
            ->modalHeading('Salin ke')
            ->modalSubmitActionLabel('Salin')
            ->schema([
                Select::make('target')
                    ->label('Folder tujuan')
                    ->options(fn () => $this->folderOptions($this->pendingCopy))
                    ->searchable()
                    ->required()
                    ->default($this->folderId ? (string) $this->folderId : 'root'),
            ])
            ->action(function (array $data): void {
                $target = $data['target'] === 'root' ? null : (int) $data['target'];

                $this->copyItems($this->pendingCopy, $target);
                $this->pendingCopy = [];
            });
    }

    /**
     * Menyalin item. $items berformat ["folder:5", "file:12"], $targetId null = paling atas.
     */
    public function copyItems(array $items, ?int $targetId = null): void
    {
        $items = $this->bersihkanItems($items);

        if ($items === []) {
            return;
        }

        if ($targetId !== null && ! LaporanFolder::whereKey($targetId)->exists()) {
            Notification::make()->title('Folder tujuan tidak ditemukan')->danger()->send();

            return;
        }

        // Rantai folder tujuan sampai root (mencegah folder disalin ke dalam dirinya sendiri)
        $ancestors = [];
        $cur = $targetId;

        for ($i = 0; $cur && $i < 100; $i++) {
            $ancestors[] = (int) $cur;
            $cur = LaporanFolder::whereKey($cur)->value('parent_id');
        }

        $stat = ['folder' => 0, 'file' => 0, 'hilang' => 0, 'dilewati' => 0];

        foreach ($items as $item) {
            [$type, $id] = explode(':', $item);
            $id = (int) $id;

            if ($type === 'folder') {
                $folder = LaporanFolder::find($id);

                if (! $folder) {
                    continue;
                }

                if (in_array($id, $ancestors, true)) {
                    $stat['dilewati']++;

                    continue;
                }

                $this->salinFolder($folder, $targetId, $this->namaFolderUnik($folder->nama, $targetId), $stat);
            } else {
                $file = LaporanFile::find($id);

                if (! $file) {
                    continue;
                }

                $this->salinFile($file, $targetId, $this->namaFileUnik($file->nama, $targetId), $stat);
            }
        }

        $ringkas = [];
        if ($stat['folder'] > 0) {
            $ringkas[] = $stat['folder'] . ' folder';
        }
        if ($stat['file'] > 0) {
            $ringkas[] = $stat['file'] . ' file';
        }

        if ($ringkas !== []) {
            Notification::make()->title('Berhasil disalin: ' . implode(' dan ', $ringkas))->success()->send();
        }

        if ($stat['hilang'] > 0 || $stat['dilewati'] > 0) {
            Notification::make()
                ->title('Sebagian item tidak disalin')
                ->body(
                    ($stat['hilang'] > 0 ? "{$stat['hilang']} file fisik tidak ditemukan di penyimpanan. " : '') .
                    ($stat['dilewati'] > 0 ? "{$stat['dilewati']} folder tidak bisa disalin ke dirinya sendiri/subfoldernya." : '')
                )
                ->warning()
                ->send();
        }
    }

    protected function salinFile(LaporanFile $src, ?int $folderId, string $nama, array &$stat): void
    {
        $disk = Storage::disk('local');

        if (! $disk->exists($src->path)) {
            $stat['hilang']++;

            return;
        }

        $newPath = 'arsip-laporan/' . Str::uuid() . '_' . $nama;
        $disk->copy($src->path, $newPath);

        LaporanFile::create([
            'folder_id'   => $folderId,
            'nama'        => $nama,
            'path'        => $newPath,
            'mime_type'   => $src->mime_type,
            'ukuran'      => $src->ukuran,
            'uploaded_by' => auth()->id(),
        ]);

        $stat['file']++;
    }

    protected function salinFolder(LaporanFolder $src, ?int $parentId, string $nama, array &$stat): void
    {
        $baru = LaporanFolder::create([
            'parent_id'  => $parentId,
            'nama'       => $nama,
            'created_by' => auth()->id(),
        ]);

        $stat['folder']++;

        foreach ($src->files as $file) {
            $this->salinFile($file, $baru->id, $file->nama, $stat);
        }

        foreach ($src->children as $child) {
            $this->salinFolder($child, $baru->id, $child->nama, $stat);
        }
    }

    /** Jika nama sudah ada di tujuan: "Salinan dari X", lalu "Salinan dari X (2)", dst. */
    protected function namaFolderUnik(string $nama, ?int $parentId): string
    {
        $ada = fn (string $n) => LaporanFolder::where('parent_id', $parentId)->where('nama', $n)->exists();

        if (! $ada($nama)) {
            return $nama;
        }

        $base = 'Salinan dari ' . $nama;
        $kandidat = $base;

        for ($n = 2; $ada($kandidat); $n++) {
            $kandidat = "{$base} ({$n})";
        }

        return $kandidat;
    }

    protected function namaFileUnik(string $nama, ?int $folderId): string
    {
        $ada = fn (string $n) => LaporanFile::where('folder_id', $folderId)->where('nama', $n)->exists();

        if (! $ada($nama)) {
            return $nama;
        }

        $ext  = pathinfo($nama, PATHINFO_EXTENSION);
        $base = 'Salinan dari ' . pathinfo($nama, PATHINFO_FILENAME);
        $kandidat = $base . ($ext ? ".{$ext}" : '');

        for ($n = 2; $ada($kandidat); $n++) {
            $kandidat = "{$base} ({$n})" . ($ext ? ".{$ext}" : '');
        }

        return $kandidat;
    }

    /* ---------------- Hapus Terpilih / Bulk Delete ---------------- */

    /** Membuka konfirmasi hapus untuk banyak item. */
    public function hapusTerpilih(array $items): void
    {
        $this->pendingDelete = $this->bersihkanItems($items);

        if ($this->pendingDelete === []) {
            return;
        }

        $this->mountAction('bulkDelete');
    }

    public function bulkDeleteAction(): Action
    {
        return Action::make('bulkDelete')
            ->color('danger')
            ->requiresConfirmation()
            ->modalHeading(fn () => 'Hapus ' . count($this->pendingDelete) . ' item?')
            ->modalDescription('Folder akan dihapus beserta seluruh subfolder dan file di dalamnya. Tindakan ini tidak dapat dibatalkan.')
            ->modalSubmitActionLabel('Hapus semua')
            ->action(function (): void {
                $disk = Storage::disk('local');
                $folder = 0;
                $file = 0;

                foreach ($this->pendingDelete as $item) {
                    [$type, $id] = explode(':', $item);

                    if ($type === 'folder') {
                        // Folder induk yang sudah terhapus ikut menghapus anaknya, jadi cukup dilewati bila tidak ada
                        if ($model = LaporanFolder::find((int) $id)) {
                            $model->deleteTree();
                            $folder++;
                        }
                    } elseif ($model = LaporanFile::find((int) $id)) {
                        $disk->delete($model->path);
                        $disk->delete('arsip-preview/' . $model->id . '.pdf');
                        $model->delete();
                        $file++;
                    }
                }

                $this->pendingDelete = [];

                $ringkas = array_filter([
                    $folder ? "{$folder} folder" : null,
                    $file ? "{$file} file" : null,
                ]);

                Notification::make()
                    ->title('Berhasil dihapus: ' . (implode(' dan ', $ringkas) ?: '0 item'))
                    ->success()
                    ->send();
            });
    }

    /* ---------------- Drop Upload ---------------- */

    /**
     * Menyimpan batch file hasil seret-lepas.
     * $paths sejajar dengan $this->uploads, mis. "2025/Januari/laporan.pdf".
     */
    public function simpanDrop(array $paths, ?int $targetId = null): array
    {
        if ($targetId !== null && ! LaporanFolder::whereKey($targetId)->exists()) {
            $targetId = null;
        }

        $disk  = Storage::disk('local');
        $files = array_values((array) $this->uploads);
        $this->uploads = [];

        $ok = 0;
        $gagal = [];

        foreach ($files as $i => $tmp) {
            $rel = (string) ($paths[$i] ?? $tmp->getClientOriginalName());

            $segments = array_values(array_filter(
                explode('/', str_replace('\\', '/', $rel)),
                fn ($s) => $s !== '' && $s !== '.' && $s !== '..'
            ));

            $nama = array_pop($segments);

            if (! $nama) {
                continue;
            }

            $ext = strtolower(pathinfo($nama, PATHINFO_EXTENSION));

            if (! in_array($ext, self::EKSTENSI_DIIZINKAN, true)) {
                $gagal[] = $nama;

                continue;
            }

            // Buat subfolder sesuai struktur folder yang diseret
            $folderId = $targetId;

            foreach ($segments as $seg) {
                $folderId = LaporanFolder::firstOrCreate(
                    ['parent_id' => $folderId, 'nama' => $seg],
                    ['created_by' => auth()->id()]
                )->id;
            }

            $path = $tmp->storeAs('arsip-laporan', Str::uuid() . '_' . $nama, 'local');

            LaporanFile::create([
                'folder_id'   => $folderId,
                'nama'        => $nama,
                'path'        => $path,
                'mime_type'   => $disk->mimeType($path),
                'ukuran'      => $disk->size($path),
                'uploaded_by' => auth()->id(),
            ]);

            $ok++;
        }

        return ['ok' => $ok, 'gagal' => $gagal];
    }

    /** Notifikasi ringkasan setelah semua batch selesai. */
    public function laporanDrop(int $ok, array $gagal = []): void
    {
        if ($ok > 0) {
            Notification::make()->title("{$ok} file berhasil diupload")->success()->send();
        }

        if ($gagal !== []) {
            $contoh = implode(', ', array_slice($gagal, 0, 5));

            Notification::make()
                ->title(count($gagal) . ' file tidak diupload')
                ->body('Format tidak didukung, lebih dari 50 MB, atau gagal dikirim: ' . $contoh . (count($gagal) > 5 ? ', ...' : ''))
                ->warning()
                ->send();
        }
    }

    /* ---------------- Bulk Folder ---------------- */

    /** "Bulan {1-3}" menjadi ["Bulan 1","Bulan 2","Bulan 3"]. */
    protected function ekspansiRentang(string $baris): array
    {
        if (! preg_match('/\{(\d+)-(\d+)\}/', $baris, $m)) {
            return [$baris];
        }

        $awal = (int) $m[1];
        $akhir = (int) $m[2];

        if ($akhir < $awal || ($akhir - $awal) > 200) {
            return [$baris];
        }

        $keluar = [];

        for ($i = $awal; $i <= $akhir; $i++) {
            $keluar[] = preg_replace('/\{\d+-\d+\}/', (string) $i, $baris, 1);
        }

        return $keluar;
    }

    /** Mengubah teks menjadi daftar path: [['2025','Januari'], ['MOU-PKS']]. */
    protected function parseDaftarFolder(string $teks): array
    {
        $hasil = [];

        foreach (preg_split('/[\r\n,;]+/', $teks) as $entri) {
            $entri = trim($entri);

            if ($entri === '') {
                continue;
            }

            foreach ($this->ekspansiRentang($entri) as $baris) {
                $segments = array_values(array_filter(array_map(
                    fn ($s) => trim(preg_replace('/[\\\\:*?"<>|]/', '', $s)),
                    explode('/', $baris)
                ), fn ($s) => $s !== '' && $s !== '.' && $s !== '..'));

                $segments = array_map(fn ($s) => Str::limit($s, 255, ''), $segments);

                if ($segments !== []) {
                    $hasil[] = $segments;
                }
            }
        }

        // Batas pengaman agar tidak membuat ribuan folder tanpa sengaja
        return array_slice($hasil, 0, 500);
    }

    /* ---------------- Header Actions ---------------- */

    protected function getHeaderActions(): array
    {
        return [
            $this->bulkFolderAction(),
            $this->createFolderAction(),
            $this->uploadFileAction(),
        ];
    }

    public function bulkFolderAction(): Action
    {
        return Action::make('bulkFolder')
            ->label('Buat Banyak Folder')
            ->icon(Heroicon::OutlinedFolderPlus)
            ->color('gray')
            ->modalHeading('Buat Banyak Folder')
            ->modalDescription('Satu baris satu folder. Pemisah koma (,) atau titik koma (;) juga bisa. Gunakan / untuk subfolder, contoh: 2025/Januari. Gunakan {1-12} untuk deret angka, contoh: Bulan {1-12}.')
            ->modalSubmitActionLabel('Buat Folder')
            ->schema([
                Textarea::make('daftar')
                    ->label('Daftar folder')
                    ->placeholder("2025/Januari\n2025/Februari\nMOU-PKS\nBulan {1-12}")
                    ->rows(10)
                    ->required()
                    ->helperText(fn () => 'Dibuat di: ' . ($this->getCurrentFolder()?->nama ?? 'Arsip Laporan (paling atas)')),
            ])
            ->action(function (array $data): void {
                $paths = $this->parseDaftarFolder($data['daftar']);

                if ($paths === []) {
                    Notification::make()->title('Tidak ada nama folder yang valid')->warning()->send();

                    return;
                }

                $baru = 0;
                $ada = 0;

                foreach ($paths as $segments) {
                    $parentId = $this->folderId;

                    foreach ($segments as $seg) {
                        $folder = LaporanFolder::firstOrCreate(
                            ['parent_id' => $parentId, 'nama' => $seg],
                            ['created_by' => auth()->id()]
                        );

                        $folder->wasRecentlyCreated ? $baru++ : $ada++;
                        $parentId = $folder->id;
                    }
                }

                Notification::make()
                    ->title("{$baru} folder dibuat")
                    ->body($ada > 0 ? "{$ada} folder sudah ada sehingga dilewati." : null)
                    ->success()
                    ->send();
            });
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
                    // Prefix UUID agar nama tidak bentrok; nama asli disimpan di DB
                    ->getUploadedFileNameForStorageUsing(
                        fn (TemporaryUploadedFile $file): string =>
                            Str::uuid() . '_' . $file->getClientOriginalName()
                    )
                    ->helperText('Semua jenis file diterima. Untuk seret-lepas, ekstensi dibatasi di sisi server.'),
            ])
            ->action(function (array $data): void {
                $disk = Storage::disk('local');

                foreach ($data['files'] as $path) {
                    $basename = basename($path);
                    $nama = Str::after($basename, '_');

                    // Tetap hormati whitelist ekstensi
                    $ext = strtolower(pathinfo($nama, PATHINFO_EXTENSION));

                    if (! in_array($ext, self::EKSTENSI_DIIZINKAN, true)) {
                        $disk->delete($path);

                        continue;
                    }

                    LaporanFile::create([
                        'folder_id' => $this->folderId,
                        'nama' => $nama,
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

    public function renameAction(): Action
    {
        return Action::make('rename')
            ->modalHeading('Ganti nama')
            ->modalSubmitActionLabel('Simpan')
            ->fillForm(function (array $arguments): array {
                $model = $arguments['type'] === 'folder'
                    ? LaporanFolder::find($arguments['id'])
                    : LaporanFile::find($arguments['id']);

                return ['nama' => $model?->nama];
            })
            ->schema([
                TextInput::make('nama')->label('Nama')->required()->maxLength(255),
            ])
            ->action(function (array $data, array $arguments): void {
                $nama = trim($data['nama']);

                if ($arguments['type'] === 'folder') {
                    LaporanFolder::find($arguments['id'])?->update(['nama' => $nama]);
                } else {
                    $file = LaporanFile::find($arguments['id']);

                    if ($file) {
                        // Pertahankan ekstensi asli agar tipe file tidak berubah
                        $ext = pathinfo($file->nama, PATHINFO_EXTENSION);
                        if ($ext && strtolower(pathinfo($nama, PATHINFO_EXTENSION)) !== strtolower($ext)) {
                            $nama .= '.' . $ext;
                        }

                        $file->update(['nama' => $nama]);
                    }
                }

                Notification::make()->title('Nama diperbarui')->success()->send();
            });
    }

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
                    Storage::disk('local')->delete('arsip-preview/' . $file->id . '.pdf'); // hapus cache preview
                    $file->delete();
                }

                Notification::make()->title('File dihapus')->success()->send();
            });
    }

    // public function downloadFileAction(): Action
    // {
    //     return Action::make('downloadFile')
    //         ->label('Download')
    //         ->icon(Heroicon::OutlinedArrowDownTray)
    //         ->iconButton()
    //         ->action(function (array $arguments) {
    //             $file = LaporanFile::findOrFail($arguments['id']);
    //
    //             return Storage::disk('local')->download($file->path, $file->nama);
    //         });
    // }
    //
    // ^ Dihapus / dikomentari karena tombol Download sekarang berupa link biasa (<a href>).
}