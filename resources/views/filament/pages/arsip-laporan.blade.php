<x-filament-panels::page>

<style>
    .gd { --gd-bg:#f0f4f9; --gd-bg-hover:#e3eaf3; --gd-border:#dadce0; --gd-text:#1f1f1f; --gd-muted:#5f6368; --gd-card:#ffffff; --gd-sel:#c2e7ff; }
    .dark .gd { --gd-bg:#2d2f31; --gd-bg-hover:#3a3d40; --gd-border:#444746; --gd-text:#e3e3e3; --gd-muted:#9aa0a6; --gd-card:#1f1f1f; --gd-sel:#0b3b5c; }

    .gd * { box-sizing: border-box; }
    .gd button { cursor: pointer; background: none; border: 0; font: inherit; color: inherit; }

    /* Toolbar */
    .gd-toolbar { display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:12px; margin-bottom:20px; }
    .gd-crumbs { display:flex; flex-wrap:wrap; align-items:center; gap:2px; font-size:20px; color:var(--gd-text); }
    .gd-crumb { padding:6px 12px; border-radius:999px; }
    .gd-crumb:hover { background:var(--gd-bg-hover); }
    .gd-crumb.active { font-weight:500; }
    .gd-sep { color:var(--gd-muted); }

    .gd-tools { display:flex; align-items:center; gap:10px; }
    .gd-search { display:flex; align-items:center; gap:8px; background:var(--gd-bg); border-radius:999px; padding:0 16px; height:44px; min-width:260px; }
    .gd-search input { background:transparent; border:0; outline:0; box-shadow:none; flex:1; color:var(--gd-text); font-size:14px; padding:0; }
    .gd-search input:focus { box-shadow:none; outline:0; }
    .gd-search svg { width:20px; height:20px; color:var(--gd-muted); }

    .gd-toggle { display:flex; border:1px solid var(--gd-border); border-radius:999px; overflow:hidden; }
    .gd-toggle button { padding:8px 14px; display:flex; align-items:center; color:var(--gd-muted); }
    .gd-toggle button.on { background:var(--gd-sel); color:var(--gd-text); }
    .gd-toggle svg { width:20px; height:20px; }

    /* Section title */
    .gd-title { font-size:14px; font-weight:500; color:var(--gd-muted); margin:24px 0 12px; }

    /* Folder */
    .gd-folders { display:grid; grid-template-columns:repeat(auto-fill,minmax(240px,1fr)); gap:12px; }
    .gd-folder { display:flex; align-items:center; gap:12px; background:var(--gd-bg); border-radius:12px; padding:0 8px 0 16px; height:52px; transition:background .15s; }
    .gd-folder:hover { background:var(--gd-bg-hover); }
    .gd-folder-main { display:flex; align-items:center; gap:12px; flex:1; min-width:0; text-align:left; height:100%; }
    .gd-folder-main svg { width:24px; height:24px; color:var(--gd-muted); flex-shrink:0; }
    .gd-folder-name { font-size:14px; font-weight:500; color:var(--gd-text); overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
    .gd-folder-meta { font-size:11px; color:var(--gd-muted); }

    /* File card (grid) */
    .gd-files { display:grid; grid-template-columns:repeat(auto-fill,minmax(210px,1fr)); gap:16px; }
    .gd-file { background:var(--gd-bg); border-radius:12px; padding:8px; transition:background .15s; }
    .gd-file:hover { background:var(--gd-bg-hover); }
    .gd-file-head { display:flex; align-items:center; gap:8px; padding:6px 4px 8px; }
    .gd-file-head .gd-ico { width:20px; height:20px; flex-shrink:0; }
    .gd-file-name { flex:1; min-width:0; font-size:13px; font-weight:500; color:var(--gd-text); overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
    .gd-file-preview { background:var(--gd-card); border-radius:8px; height:130px; display:flex; align-items:center; justify-content:center; }
    .gd-file-preview svg { width:56px; height:56px; }
    .gd-file-foot { display:flex; align-items:center; justify-content:space-between; padding:8px 4px 0; font-size:11px; color:var(--gd-muted); }
    .gd-actions { display:flex; align-items:center; }

    /* List view */
    .gd-list { width:100%; border-collapse:collapse; font-size:14px; color:var(--gd-text); }
    .gd-list th { text-align:left; font-weight:500; color:var(--gd-muted); padding:10px 12px; border-bottom:1px solid var(--gd-border); }
    .gd-list td { padding:8px 12px; border-bottom:1px solid var(--gd-border); }
    .gd-list tr:hover td { background:var(--gd-bg); }
    .gd-list .gd-cell-name { display:flex; align-items:center; gap:12px; }
    .gd-list .gd-cell-name svg { width:22px; height:22px; flex-shrink:0; }
    .gd-muted { color:var(--gd-muted); }

    /* Warna ikon tipe file */
    .t-pdf { color:#ea4335; } .t-word { color:#4285f4; } .t-excel { color:#0f9d58; }
    .t-ppt { color:#f4b400; } .t-image { color:#d93025; } .t-other { color:#5f6368; }

    .gd-empty { text-align:center; padding:60px 20px; color:var(--gd-muted); }
    .gd-empty svg { width:72px; height:72px; margin:0 auto 12px; opacity:.5; }

    /* Klik & preview */
    .gd-click { cursor:pointer; }
    .gd-file-preview.gd-click:hover { outline:2px solid var(--gd-sel); }
    .gd-namebtn { text-align:left; min-width:0; flex:1; }
    .gd-namebtn:hover .gd-file-name, .gd-namebtn:hover span { text-decoration:underline; }

    /* Modal preview */
    .gd-modal { position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,.75); display:flex; flex-direction:column; }
    .gd-modal-bar { display:flex; align-items:center; gap:12px; padding:10px 16px; color:#fff; background:rgba(0,0,0,.4); }
    .gd-modal-title { flex:1; min-width:0; font-size:15px; font-weight:500; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
    .gd-modal-btn { display:inline-flex; align-items:center; gap:6px; padding:8px 14px; border-radius:999px; background:rgba(255,255,255,.15); color:#fff; font-size:13px; text-decoration:none; }
    .gd-modal-btn:hover { background:rgba(255,255,255,.28); }
    .gd-modal-btn svg { width:18px; height:18px; }
    .gd-modal-body { flex:1; min-height:0; display:flex; align-items:center; justify-content:center; padding:0 16px 16px; }
    .gd-modal-body iframe { width:100%; height:100%; border:0; background:#fff; border-radius:8px; }
    .gd-modal-body img { max-width:100%; max-height:100%; object-fit:contain; border-radius:8px; }
    .gd-nopreview { background:var(--gd-card); color:var(--gd-text); border-radius:16px; padding:40px; text-align:center; max-width:420px; }
    .gd-nopreview svg { width:64px; height:64px; margin:0 auto 12px; }
</style>

@php
    $folders = $this->getFolders();
    $files   = $this->getFiles();
    $icons = [
        'pdf'   => 'heroicon-o-document-text',
        'word'  => 'heroicon-o-document-text',
        'excel' => 'heroicon-o-table-cells',
        'ppt'   => 'heroicon-o-presentation-chart-bar',
        'image' => 'heroicon-o-photo',
        'other' => 'heroicon-o-document',
    ];
@endphp

<div class="gd">

    {{-- TOOLBAR: breadcrumb + search + view toggle --}}
    <div class="gd-toolbar">
        <div class="gd-crumbs">
            <button class="gd-crumb {{ $this->folderId ? '' : 'active' }}" wire:click="openFolder(null)">
                Arsip Laporan
            </button>
            @foreach ($this->getBreadcrumbTrail() as $crumb)
                <span class="gd-sep">›</span>
                <button class="gd-crumb {{ $loop->last ? 'active' : '' }}" wire:click="openFolder({{ $crumb->id }})">
                    {{ $crumb->nama }}
                </button>
            @endforeach
        </div>

        <div class="gd-tools">
            <label class="gd-search">
                <x-filament::icon icon="heroicon-o-magnifying-glass" />
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari di folder ini">
            </label>

            <div class="gd-toggle">
                <button type="button" wire:click="$set('viewMode','grid')" class="{{ $viewMode === 'grid' ? 'on' : '' }}" title="Tampilan grid">
                    <x-filament::icon icon="heroicon-o-squares-2x2" />
                </button>
                <button type="button" wire:click="$set('viewMode','list')" class="{{ $viewMode === 'list' ? 'on' : '' }}" title="Tampilan daftar">
                    <x-filament::icon icon="heroicon-o-list-bullet" />
                </button>
            </div>
        </div>
    </div>

    {{-- FOLDER --}}
    @if ($folders->isNotEmpty())
        <div class="gd-title">Folder</div>
        <div class="gd-folders">
            @foreach ($folders as $folder)
                <div class="gd-folder" wire:key="folder-{{ $folder->id }}">
                    <button class="gd-folder-main" wire:click="openFolder({{ $folder->id }})">
                        <x-filament::icon icon="heroicon-s-folder" />
                        <div style="min-width:0">
                            <div class="gd-folder-name">{{ $folder->nama }}</div>
                            <div class="gd-folder-meta">{{ $folder->children_count }} folder · {{ $folder->files_count }} file</div>
                        </div>
                    </button>
                    {{ ($this->deleteFolderAction)(['id' => $folder->id]) }}
                </div>
            @endforeach
        </div>
    @endif

    {{-- FILE --}}
    @if ($files->isNotEmpty())
        <div class="gd-title">File</div>

        @if ($viewMode === 'grid')
            <div class="gd-files">
                @foreach ($files as $file)
                    <div class="gd-file" wire:key="file-{{ $file->id }}">
                        <button type="button" class="gd-file-head gd-namebtn" style="width:100%" wire:click="openPreview({{ $file->id }})">
                            <x-filament::icon :icon="$icons[$file->tipe]" class="gd-ico t-{{ $file->tipe }}" />
                            <div class="gd-file-name" title="{{ $file->nama }}">{{ $file->nama }}</div>
                        </button>

                        <div class="gd-file-preview gd-click" wire:click="openPreview({{ $file->id }})">
                            <x-filament::icon :icon="$icons[$file->tipe]" class="t-{{ $file->tipe }}" />
                        </div>

                        <div class="gd-file-foot">
                            <span>{{ $file->ukuran_format }} · {{ $file->created_at->format('d M Y') }}</span>
                            <div class="gd-actions">
                                {{ ($this->downloadFileAction)(['id' => $file->id]) }}
                                {{ ($this->deleteFileAction)(['id' => $file->id]) }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <table class="gd-list">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Diupload oleh</th>
                        <th>Tanggal</th>
                        <th>Ukuran</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($files as $file)
                        <tr wire:key="row-{{ $file->id }}">
                            <td>
                                <div class="gd-cell-name">
                                    <x-filament::icon :icon="$icons[$file->tipe]" class="t-{{ $file->tipe }}" />
                                    <button type="button" class="gd-namebtn" wire:click="openPreview({{ $file->id }})">
                                        <span>{{ $file->nama }}</span>
                                    </button>
                                </div>
                            </td>
                            <td class="gd-muted">{{ $file->uploader?->name ?? '-' }}</td>
                            <td class="gd-muted">{{ $file->created_at->format('d M Y') }}</td>
                            <td class="gd-muted">{{ $file->ukuran_format }}</td>
                            <td>
                                <div class="gd-actions" style="justify-content:flex-end">
                                    {{ ($this->downloadFileAction)(['id' => $file->id]) }}
                                    {{ ($this->deleteFileAction)(['id' => $file->id]) }}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endif

    {{-- KOSONG --}}
    @if ($folders->isEmpty() && $files->isEmpty())
        <div class="gd-empty">
            <x-filament::icon icon="heroicon-o-folder-open" />
            <div>{{ $search !== '' ? 'Tidak ada hasil untuk pencarian ini.' : 'Folder ini masih kosong.' }}</div>
            @if ($search === '')
                <div style="font-size:13px;margin-top:4px">Gunakan tombol "Folder Baru" atau "Upload File" di kanan atas.</div>
            @endif
        </div>
    @endif

    {{-- MODAL PREVIEW --}}
    @php($pv = $this->getPreviewFile())

    @if ($pv)
        <div class="gd-modal" wire:key="preview-{{ $pv->id }}"
             x-data x-on:keydown.escape.window="$wire.closePreview()">

            <div class="gd-modal-bar">
                <x-filament::icon :icon="$icons[$pv->tipe]" style="width:22px;height:22px" />
                <div class="gd-modal-title">{{ $pv->nama }}</div>

                <a class="gd-modal-btn" href="{{ route('arsip.file', $pv) }}" target="_blank">
                    <x-filament::icon icon="heroicon-o-arrow-top-right-on-square" /> Buka di tab baru
                </a>
                <a class="gd-modal-btn" href="{{ route('arsip.file', ['file' => $pv, 'unduh' => 1]) }}">
                    <x-filament::icon icon="heroicon-o-arrow-down-tray" /> Download
                </a>
                <button type="button" class="gd-modal-btn" wire:click="closePreview">
                    <x-filament::icon icon="heroicon-o-x-mark" /> Tutup
                </button>
            </div>

            <div class="gd-modal-body">
                @if ($pv->tipe === 'pdf')
                    <iframe src="{{ route('arsip.file', $pv) }}"></iframe>
                @elseif ($pv->tipe === 'image')
                    <img src="{{ route('arsip.file', $pv) }}" alt="{{ $pv->nama }}">
                @else
                    <div class="gd-nopreview">
                        <x-filament::icon :icon="$icons[$pv->tipe]" class="t-{{ $pv->tipe }}" />
                        <div style="font-weight:500;margin-bottom:6px">Preview tidak tersedia</div>
                        <div style="font-size:13px;color:var(--gd-muted);margin-bottom:18px">
                            File Word, Excel, dan PowerPoint tidak dapat ditampilkan langsung di browser.
                        </div>
                        <a class="gd-modal-btn" style="background:#1a73e8"
                           href="{{ route('arsip.file', ['file' => $pv, 'unduh' => 1]) }}">
                            <x-filament::icon icon="heroicon-o-arrow-down-tray" /> Download file
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @endif

</div>

</x-filament-panels::page>