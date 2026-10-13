<x-filament-panels::page>

<style>
    .gd { --gd-bg:#f0f4f9; --gd-hover:#e3eaf3; --gd-border:#dadce0; --gd-text:#1f1f1f; --gd-muted:#5f6368; --gd-card:#fff; --gd-sel:#c2e7ff; }
    .dark .gd { --gd-bg:#2d2f31; --gd-hover:#3a3d40; --gd-border:#444746; --gd-text:#e3e3e3; --gd-muted:#9aa0a6; --gd-card:#1f1f1f; --gd-sel:#0b3b5c; }
    .gd * { box-sizing:border-box; }
    .gd button, .gd a { font:inherit; color:inherit; text-decoration:none; }
    .gd button { cursor:pointer; background:none; border:0; }
    .gd svg { width:20px; height:20px; flex-shrink:0; }

    /* Toolbar */
    .gd-top { display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:12px; margin-bottom:14px; }
    .gd-crumbs { display:flex; flex-wrap:wrap; align-items:center; font-size:20px; color:var(--gd-text); }
    .gd-crumb { padding:6px 12px; border-radius:999px; }
    .gd-crumb:hover { background:var(--gd-hover); }
    .gd-crumb.active { font-weight:500; }
    .gd-sep { color:var(--gd-muted); }

    .gd-toggle { display:flex; border:1px solid var(--gd-border); border-radius:999px; overflow:hidden; }
    .gd-toggle button { padding:8px 14px; display:flex; align-items:center; gap:6px; color:var(--gd-muted); }
    .gd-toggle button.on { background:var(--gd-sel); color:var(--gd-text); }

    /* Bar item dipilih */
    .gd-bulk { display:flex; align-items:center; gap:6px; background:var(--gd-sel); color:var(--gd-text); border-radius:999px; padding:4px 10px 4px 4px; margin-bottom:12px; width:fit-content; font-size:14px; }
    .gd-bulk button { display:inline-flex; align-items:center; gap:6px; padding:6px 12px; border-radius:999px; }
    .gd-bulk button:hover { background:rgba(128,128,128,.25); }

    /* Filter */
    .gd-filters { display:flex; flex-wrap:wrap; align-items:center; gap:8px; margin-bottom:12px; }
    .gd-chip { display:inline-flex; align-items:center; gap:6px; border:1px solid var(--gd-border) !important; border-radius:8px; padding:6px 12px; font-size:14px; color:var(--gd-text); }
    .gd-chip:hover { background:var(--gd-hover); }
    .gd-chip.on { background:var(--gd-sel); border-color:transparent !important; }
    .gd-chip svg { width:16px; height:16px; }
    .gd-pop { position:relative; }
    .gd-pop-list { position:absolute; top:calc(100% + 4px); left:0; z-index:40; min-width:180px; background:var(--gd-card); border:1px solid var(--gd-border); border-radius:8px; padding:6px 0; box-shadow:0 4px 16px rgba(0,0,0,.25); }
    .gd-pop-list button { display:flex; align-items:center; gap:10px; width:100%; padding:8px 14px; text-align:left; font-size:14px; color:var(--gd-text); }
    .gd-pop-list button:hover { background:var(--gd-hover); }
    .gd-search { margin-left:auto; display:flex; align-items:center; gap:8px; background:var(--gd-bg); border-radius:999px; padding:0 16px; height:40px; min-width:240px; }
    .gd-search input { background:transparent; border:0; outline:0; box-shadow:none !important; flex:1; color:var(--gd-text); font-size:14px; padding:0; }
    .gd-search svg { color:var(--gd-muted); }

    /* Checkbox */
    .gd-check { display:flex; align-items:center; justify-content:center; width:36px; height:36px; cursor:pointer; opacity:0; transition:opacity .1s; flex-shrink:0; }
    .gd-check input { width:16px; height:16px; accent-color:#1a73e8; cursor:pointer; }
    .gd-body:hover .gd-check, .gd-card:hover .gd-check, .gd-folder:hover .gd-check,
    .gd.has-sel .gd-check, .gd-head .gd-check { opacity:1; }
    @media (hover:none) { .gd-check { opacity:1; } }

    /* List */
    .gd-row { display:grid; grid-template-columns:36px minmax(220px,1fr) 200px 130px 110px 44px; align-items:center; gap:8px; padding:0 8px; min-height:52px; border-bottom:1px solid var(--gd-border); color:var(--gd-text); font-size:14px; }
    .gd-head { min-height:44px; color:var(--gd-muted); font-weight:500; position:sticky; top:0; }
    .gd-head button { display:inline-flex; align-items:center; gap:6px; padding:6px 8px; border-radius:999px; font-weight:500; }
    .gd-head button:hover { background:var(--gd-hover); }
    .gd-head button.on { color:var(--gd-text); }
    .gd-head svg { width:16px; height:16px; }
    .gd-body:hover { background:var(--gd-bg); }
    .gd-name { display:flex; align-items:center; gap:14px; min-width:0; text-align:left; padding:12px 0; width:100%; }
    .gd-name span { overflow:hidden; text-overflow:ellipsis; white-space:nowrap; font-weight:500; }
    .gd-muted { color:var(--gd-muted); overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
    @media (max-width:900px) { .gd-row { grid-template-columns:36px minmax(160px,1fr) 100px 44px; } .gd-col-own, .gd-col-size { display:none; } }

    /* Status seleksi & drag */
    .sel { background:var(--gd-sel) !important; }
    .dragging { opacity:.45; }
    .drop { background:var(--gd-sel) !important; outline:2px solid #1a73e8; outline-offset:-2px; border-radius:8px; }
    .gd-folder.drop, .gd-card.drop { border-radius:12px; }
    .gd-ghost { position:fixed; top:-200px; left:-200px; display:flex; align-items:center; gap:10px; background:#fff; color:#1f1f1f; padding:10px 16px; border-radius:10px; box-shadow:0 4px 16px rgba(0,0,0,.35); font:500 14px system-ui,sans-serif; max-width:260px; }
    .gd-ghost svg { width:20px; height:20px; color:#5f6368; flex-shrink:0; }
    .gd-ghost span { overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }

    /* Menu titik tiga */
    .gd-menu { position:relative; }
    .gd-dots { width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; }
    .gd-dots:hover { background:var(--gd-hover); }
    .gd-menu-list { position:absolute; right:0; top:100%; z-index:50; min-width:200px; background:var(--gd-card); border:1px solid var(--gd-border); border-radius:8px; padding:6px 0; box-shadow:0 4px 16px rgba(0,0,0,.3); }
    .gd-menu-list button, .gd-menu-list a { display:flex; align-items:center; gap:12px; width:100%; padding:9px 14px; font-size:14px; text-align:left; color:var(--gd-text); }
    .gd-menu-list button:hover, .gd-menu-list a:hover { background:var(--gd-hover); }
    .gd-menu-list .danger { color:#d93025; }
    .gd-menu-list hr { border:0; border-top:1px solid var(--gd-border); margin:6px 0; }

    /* Grid */
    .gd-title { font-size:14px; font-weight:500; color:var(--gd-muted); margin:20px 0 10px; }
    .gd-folders { display:grid; grid-template-columns:repeat(auto-fill,minmax(240px,1fr)); gap:12px; }
    .gd-folder { display:flex; align-items:center; background:var(--gd-bg); border-radius:12px; padding:0 4px; height:52px; }
    .gd-folder:hover { background:var(--gd-hover); }
    .gd-folder .gd-name { padding:0; height:52px; }
    .gd-files { display:grid; grid-template-columns:repeat(auto-fill,minmax(210px,1fr)); gap:16px; }
    .gd-card { background:var(--gd-bg); border-radius:12px; padding:8px; }
    .gd-card:hover { background:var(--gd-hover); }
    .gd-card-head { display:flex; align-items:center; gap:4px; padding:0 0 8px; font-size:13px; font-weight:500; color:var(--gd-text); }
    .gd-card-head .gd-name { padding:0; }
    .gd-preview { background:var(--gd-card); border-radius:8px; height:130px; display:flex; align-items:center; justify-content:center; cursor:pointer; }
    .gd-preview svg { width:56px; height:56px; }
    .gd-card-foot { padding:8px 4px 0; font-size:11px; color:var(--gd-muted); }

    /* Warna ikon */
    .t-folder { color:var(--gd-muted); } .t-pdf { color:#ea4335; } .t-word { color:#4285f4; } .t-excel { color:#0f9d58; }
    .t-ppt { color:#f4b400; } .t-image { color:#d93025; } .t-text { color:var(--gd-muted); } .t-other { color:var(--gd-muted); }

    .gd-empty { text-align:center; padding:60px 20px; color:var(--gd-muted); }
    .gd-empty svg { width:72px; height:72px; margin:0 auto 12px; opacity:.5; }

    /* Modal preview */
    .gd-modal { position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,.75); display:flex; flex-direction:column; }
    .gd-modal-bar { display:flex; align-items:center; gap:12px; padding:10px 16px; color:#fff; background:rgba(0,0,0,.4); }
    .gd-modal-title { flex:1; min-width:0; font-size:15px; font-weight:500; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
    .gd-modal-btn { display:inline-flex; align-items:center; gap:6px; padding:8px 14px; border-radius:999px; background:rgba(255,255,255,.15); color:#fff !important; font-size:13px; }
    .gd-modal-btn:hover { background:rgba(255,255,255,.28); }
    .gd-modal-body { flex:1; min-height:0; display:flex; align-items:center; justify-content:center; padding:0 16px 16px; }
    .gd-modal-body iframe { width:100%; height:100%; border:0; background:#fff; border-radius:8px; }
    .gd-modal-body img { max-width:100%; max-height:100%; object-fit:contain; border-radius:8px; }
    .gd-nopreview { background:var(--gd-card); color:var(--gd-text); border-radius:16px; padding:40px; text-align:center; max-width:420px; }
    .gd-nopreview svg { width:64px; height:64px; margin:0 auto 12px; }

    /* Seret-lepas upload */
    .gd-dropzone { position:fixed; inset:0; z-index:60; pointer-events:none; border:3px solid #8ab4f8; background:rgba(26,115,232,.14); display:flex; align-items:flex-end; justify-content:center; padding-bottom:40px; }
    .gd-dropzone-pill { background:#a8c7fa; color:#041e49; border-radius:999px; padding:18px 40px; display:flex; flex-direction:column; align-items:center; gap:6px; font-size:14px; }
    .gd-dropzone-pill svg { width:48px; height:48px; }
    .gd-dropzone-pill strong { font-weight:600; }

    .gd-upl { position:fixed; right:24px; bottom:24px; z-index:70; width:320px; background:var(--gd-card); color:var(--gd-text); border:1px solid var(--gd-border); border-radius:12px; padding:14px 16px; box-shadow:0 4px 20px rgba(0,0,0,.4); font-size:14px; }
    .gd-upl-bar { height:6px; background:var(--gd-bg); border-radius:999px; overflow:hidden; margin-top:10px; }
    .gd-upl-bar > div { height:100%; background:#1a73e8; transition:width .2s; }
</style>

<script>
    window.arsipDrive = function () {
        return {
            selected: [],
            dragItems: [],
            overId: null, // id folder, atau 'root'
            dropActive: false,
            dropDepth: 0,
            uploading: false,
            progress: 0,
            upInfo: '',

            init() {
                // Kosongkan pilihan saat pindah folder / mencari / memfilter
                ['folderId', 'search', 'filterJenis'].forEach((prop) => {
                    this.$wire.$watch(prop, () => { this.selected = []; });
                });
            },

            clear() { this.selected = []; },

            allSelected() {
                const n = this.$root.querySelectorAll('[data-key]').length;
                return n > 0 && this.selected.length === n;
            },

            toggleAll(checked) {
                this.selected = checked
                    ? Array.from(this.$root.querySelectorAll('[data-key]')).map((el) => el.dataset.key)
                    : [];
            },

            isFileDrag(e) {
                return Array.from(e.dataTransfer?.types || []).includes('Files');
            },

            extEnter(e) {
                if (!this.isFileDrag(e)) return;
                e.preventDefault();
                this.dropDepth++;
                this.dropActive = true;
            },

            extOver(e) {
                if (!this.isFileDrag(e)) return;
                e.preventDefault();
                e.dataTransfer.dropEffect = 'copy';
            },

            extLeave(e) {
                if (!this.dropActive) return;
                this.dropDepth = Math.max(0, this.dropDepth - 1);
                if (this.dropDepth === 0) { this.dropActive = false; this.overId = null; }
            },

            // Membaca isi folder yang diseret (rekursif)
            async walk(entry, prefix, out) {
                if (entry.isFile) {
                    const file = await new Promise((res, rej) => entry.file(res, rej));
                    out.push({ file, path: prefix + entry.name });
                } else if (entry.isDirectory) {
                    const reader = entry.createReader();
                    let batch;
                    do {
                        batch = await new Promise((res, rej) => reader.readEntries(res, rej));
                        for (const child of batch) {
                            await this.walk(child, prefix + entry.name + '/', out);
                        }
                    } while (batch.length);
                }
            },

            async extDrop(e, targetId) {
                e.preventDefault();

                this.dropActive = false;
                this.dropDepth = 0;
                this.overId = null;

                const target = targetId === undefined ? (this.$wire.folderId ?? null) : targetId;

                // Item drag harus dibaca SEKARANG (sinkron), sebelum ada await
                const dt = e.dataTransfer;
                const sources = [];

                if (dt.items && dt.items.length) {
                    for (const it of dt.items) {
                        if (it.kind !== 'file') continue;
                        const entry = it.webkitGetAsEntry ? it.webkitGetAsEntry() : null;
                        sources.push(entry ? { entry } : { file: it.getAsFile() });
                    }
                } else {
                    for (const f of dt.files) sources.push({ file: f });
                }

                this.uploading = true;
                this.progress = 0;
                this.upInfo = 'Menyiapkan file...';

                const list = [];
                for (const s of sources) {
                    if (s.entry) await this.walk(s.entry, '', list);
                    else if (s.file) list.push({ file: s.file, path: s.file.name });
                }

                const MAX_FILE = Infinity;                 // tanpa batas per file
                const MAX_BATCH_BYTES = 20 * 1024 * 1024;  // biarkan, ini ukuran kiriman per batch
                const MAX_BATCH_COUNT = 10;

                const failed = [];
                const ok = [];

                for (const x of list) {
                    (x.file.size <= MAX_FILE ? ok : failed).push(x.file.size <= MAX_FILE ? x : x.file.name);
                }

                if (!ok.length) {
                    this.uploading = false;
                    if (failed.length) await this.$wire.laporanDrop(0, failed);
                    return;
                }

                // Bagi jadi beberapa batch
                const batches = [];
                let cur = [], bytes = 0;
                for (const x of ok) {
                    if (cur.length && (bytes + x.file.size > MAX_BATCH_BYTES || cur.length >= MAX_BATCH_COUNT)) {
                        batches.push(cur); cur = []; bytes = 0;
                    }
                    cur.push(x); bytes += x.file.size;
                }
                if (cur.length) batches.push(cur);

                let done = 0, saved = 0;

                for (const b of batches) {
                    this.upInfo = 'Mengupload ' + Math.min(done + b.length, ok.length) + ' dari ' + ok.length + ' file...';

                    try {
                        await new Promise((res, rej) => {
                            this.$wire.$uploadMultiple(
                                'uploads',
                                b.map((x) => x.file),
                                res,
                                rej,
                                (ev) => {
                                    const frac = (ev.detail?.progress ?? 0) / 100;
                                    this.progress = Math.round(((done + frac * b.length) / ok.length) * 100);
                                }
                            );
                        });

                        const r = await this.$wire.simpanDrop(b.map((x) => x.path), target);
                        saved += r.ok;
                        failed.push(...r.gagal);
                    } catch (err) {
                        failed.push(...b.map((x) => x.file.name));
                        await this.$wire.$set('uploads', [], false);
                    }

                    done += b.length;
                    this.progress = Math.round((done / ok.length) * 100);
                }

                this.uploading = false;
                await this.$wire.laporanDrop(saved, failed);
            },

            dragStart(e, key) {
                this.dragItems = this.selected.includes(key) ? [...this.selected] : [key];

                e.dataTransfer.effectAllowed = 'copyMove';
                e.dataTransfer.setData('text/plain', JSON.stringify(this.dragItems));

                const row = e.currentTarget;
                const label = row.querySelector('.gd-name span')?.textContent?.trim() || 'Item';
                const ghost = document.createElement('div');
                ghost.className = 'gd-ghost';

                const icon = row.querySelector('.gd-name svg');
                if (icon) ghost.appendChild(icon.cloneNode(true));

                const text = document.createElement('span');
                text.textContent = this.dragItems.length > 1 ? this.dragItems.length + ' item' : label;
                ghost.appendChild(text);

                document.body.appendChild(ghost);
                e.dataTransfer.setDragImage(ghost, 16, 16);
                setTimeout(() => ghost.remove(), 0);
            },

            dragOver(e, id) {
                if (this.isFileDrag(e)) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.dataTransfer.dropEffect = 'copy';
                    this.overId = id === null ? 'root' : id;   // sorot folder tujuan
                    return;
                }

                if (!this.dragItems.length) return;
                if (id !== null && this.dragItems.includes('folder:' + id)) return;

                e.preventDefault();
                // Ctrl (Windows) atau Option (Mac) = salin; kursor menampilkan tanda "+"
                e.dataTransfer.dropEffect = (e.ctrlKey || e.altKey) ? 'copy' : 'move';
                this.overId = id === null ? 'root' : id;
            },

            leave(e) {
                if (!e.currentTarget.contains(e.relatedTarget)) this.overId = null;
            },

            async drop(e, id) {
                if (this.isFileDrag(e)) {
                    e.stopPropagation();
                    return this.extDrop(e, id);               // unggah ke folder yang dijatuhi
                }

                e.preventDefault();

                const items = this.dragItems;
                const salin = e.ctrlKey || e.altKey;
                this.reset();

                if (!items.length) return;
                if (id !== null && items.includes('folder:' + id)) return;

                if (salin) {
                    await this.$wire.copyItems(items, id);
                } else {
                    await this.$wire.moveItems(items, id);
                }

                this.selected = [];
            },

            reset() {
                this.dragItems = [];
                this.overId = null;
            },
        };
    };
</script>

@php
    $folders = $this->getFolders();
    $files   = $this->getFiles();

    $icons = [
        'pdf' => 'heroicon-o-document-text', 'word' => 'heroicon-o-document-text',
        'excel' => 'heroicon-o-table-cells', 'ppt' => 'heroicon-o-presentation-chart-bar',
        'image' => 'heroicon-o-photo', 'text' => 'heroicon-o-document-text',
        'other' => 'heroicon-o-document',
    ];

    $ikon = fn ($tipe) => $icons[$tipe] ?? $icons['other'];

    $jenisOpsi = [
        'folder' => 'Folder', 'pdf' => 'PDF', 'word' => 'Dokumen Word',
        'excel' => 'Spreadsheet', 'ppt' => 'Presentasi', 'image' => 'Gambar',
    ];

    $kosong = $folders->isEmpty() && $files->isEmpty();
@endphp

<div class="gd" x-data="arsipDrive()" :class="{ 'has-sel': selected.length > 0 }"
     x-on:dragenter="extEnter($event)"
     x-on:dragover="extOver($event)"
     x-on:dragleave="extLeave($event)"
     x-on:drop="extDrop($event)"
     x-on:dragover.window="if (isFileDrag($event)) $event.preventDefault()"
     x-on:drop.window="if (isFileDrag($event)) $event.preventDefault()">

    {{-- BREADCRUMB (juga area drop) + TOGGLE TAMPILAN --}}
    <div class="gd-top">
        <div class="gd-crumbs">
            <button type="button" class="gd-crumb {{ $this->folderId ? '' : 'active' }}"
                    :class="{ 'drop': overId === 'root' }"
                    wire:click="openFolder(null)"
                    x-on:dragover="dragOver($event, null)"
                    x-on:dragleave="leave($event)"
                    x-on:drop="drop($event, null)">
                Arsip Laporan
            </button>

            @foreach ($this->getBreadcrumbTrail() as $crumb)
                <span class="gd-sep">›</span>
                <button type="button" class="gd-crumb {{ $loop->last ? 'active' : '' }}"
                        :class="{ 'drop': overId === {{ $crumb->id }} }"
                        wire:click="openFolder({{ $crumb->id }})"
                        x-on:dragover="dragOver($event, {{ $crumb->id }})"
                        x-on:dragleave="leave($event)"
                        x-on:drop="drop($event, {{ $crumb->id }})">
                    {{ $crumb->nama }}
                </button>
            @endforeach
        </div>

        <div class="gd-toggle">
            <button type="button" wire:click="$set('viewMode','list')" class="{{ $viewMode === 'list' ? 'on' : '' }}" title="Tampilan daftar">
                @if ($viewMode === 'list') <x-filament::icon icon="heroicon-m-check" /> @endif
                <x-filament::icon icon="heroicon-o-list-bullet" />
            </button>
            <button type="button" wire:click="$set('viewMode','grid')" class="{{ $viewMode === 'grid' ? 'on' : '' }}" title="Tampilan grid">
                @if ($viewMode === 'grid') <x-filament::icon icon="heroicon-m-check" /> @endif
                <x-filament::icon icon="heroicon-o-squares-2x2" />
            </button>
        </div>
    </div>

    {{-- BAR ITEM DIPILIH --}}
    <div class="gd-bulk" x-show="selected.length > 0" x-cloak>
        <button type="button" x-on:click="clear()" title="Batalkan pilihan">
            <x-filament::icon icon="heroicon-m-x-mark" />
        </button>
        <span><span x-text="selected.length"></span> dipilih</span>
        <button type="button" x-on:click="$wire.pindahkan(selected)">
            <x-filament::icon icon="heroicon-o-arrow-right-circle" /> Pindahkan
        </button>
        <button type="button" x-on:click="$wire.salin(selected)">
            <x-filament::icon icon="heroicon-o-document-duplicate" /> Salin
        </button>
        <button type="button" style="color:#d93025"
                x-on:click="$wire.hapusTerpilih(selected)">
            <x-filament::icon icon="heroicon-o-trash" /> Hapus
        </button>
    </div>

    {{-- FILTER --}}
    <div class="gd-filters">
        <div class="gd-pop" x-data="{ open: false }" x-on:click.outside="open = false">
            <button type="button" class="gd-chip {{ $filterJenis !== '' ? 'on' : '' }}" x-on:click="open = !open">
                {{ $filterJenis !== '' ? $jenisOpsi[$filterJenis] : 'Jenis' }}
                <x-filament::icon icon="heroicon-m-chevron-down" />
            </button>
            <div class="gd-pop-list" x-show="open" x-cloak x-on:click="open = false">
                @foreach ($jenisOpsi as $val => $label)
                    <button type="button" wire:click="$set('filterJenis','{{ $val }}')">
                        @if ($filterJenis === $val) <x-filament::icon icon="heroicon-m-check" /> @else <span style="width:20px"></span> @endif
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>

        @if ($filterJenis !== '')
            <button type="button" class="gd-chip" wire:click="$set('filterJenis','')">
                <x-filament::icon icon="heroicon-m-x-mark" /> Hapus filter
            </button>
        @endif

        <label class="gd-search">
            <x-filament::icon icon="heroicon-o-magnifying-glass" />
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari di folder ini">
        </label>
    </div>

    {{-- ============ TAMPILAN DAFTAR ============ --}}
    @if ($viewMode === 'list' && ! $kosong)
        <div>
            <div class="gd-row gd-head">
                <label class="gd-check" title="Pilih semua">
                    <input type="checkbox" :checked="allSelected()" x-on:change="toggleAll($event.target.checked)">
                </label>
                <div>
                    <button type="button" wire:click="urutkan('nama')" class="{{ $sortBy === 'nama' ? 'on' : '' }}">
                        Nama
                        @if ($sortBy === 'nama')
                            <x-filament::icon :icon="$sortDir === 'asc' ? 'heroicon-m-arrow-up' : 'heroicon-m-arrow-down'" />
                        @endif
                    </button>
                </div>
                <div class="gd-col-own">Pemilik</div>
                <div>
                    <button type="button" wire:click="urutkan('tanggal')" class="{{ $sortBy === 'tanggal' ? 'on' : '' }}">
                        Tanggal diubah
                        @if ($sortBy === 'tanggal')
                            <x-filament::icon :icon="$sortDir === 'asc' ? 'heroicon-m-arrow-up' : 'heroicon-m-arrow-down'" />
                        @endif
                    </button>
                </div>
                <div class="gd-col-size">
                    <button type="button" wire:click="urutkan('ukuran')" class="{{ $sortBy === 'ukuran' ? 'on' : '' }}">
                        Ukuran file
                        @if ($sortBy === 'ukuran')
                            <x-filament::icon :icon="$sortDir === 'asc' ? 'heroicon-m-arrow-up' : 'heroicon-m-arrow-down'" />
                        @endif
                    </button>
                </div>
                <div></div>
            </div>

            @foreach ($folders as $folder)
                <div class="gd-row gd-body" wire:key="lf-{{ $folder->id }}"
                     data-key="folder:{{ $folder->id }}"
                     draggable="true"
                     :class="{ 'sel': selected.includes('folder:{{ $folder->id }}'), 'dragging': dragItems.includes('folder:{{ $folder->id }}'), 'drop': overId === {{ $folder->id }} }"
                     x-on:dragstart="dragStart($event, 'folder:{{ $folder->id }}')"
                     x-on:dragend="reset()"
                     x-on:dragover="dragOver($event, {{ $folder->id }})"
                     x-on:dragleave="leave($event)"
                     x-on:drop="drop($event, {{ $folder->id }})"
                     wire:dblclick="openFolder({{ $folder->id }})">
                    <label class="gd-check"><input type="checkbox" value="folder:{{ $folder->id }}" x-model="selected"></label>
                    <button type="button" class="gd-name" wire:click="openFolder({{ $folder->id }})">
                        <x-filament::icon icon="heroicon-s-folder" class="t-folder" />
                        <span>{{ $folder->nama }}</span>
                    </button>
                    <div class="gd-muted gd-col-own">{{ $folder->creator?->name ?? '-' }}</div>
                    <div class="gd-muted">{{ $folder->updated_at->format('d M Y') }}</div>
                    <div class="gd-muted gd-col-size">—</div>
                    @include('filament.pages.partials.arsip-menu', ['type' => 'folder', 'id' => $folder->id])
                </div>
            @endforeach

            @foreach ($files as $file)
                <div class="gd-row gd-body" wire:key="lfile-{{ $file->id }}"
                     data-key="file:{{ $file->id }}"
                     draggable="true"
                     :class="{ 'sel': selected.includes('file:{{ $file->id }}'), 'dragging': dragItems.includes('file:{{ $file->id }}') }"
                     x-on:dragstart="dragStart($event, 'file:{{ $file->id }}')"
                     x-on:dragend="reset()"
                     wire:dblclick="openPreview({{ $file->id }})">
                    <label class="gd-check"><input type="checkbox" value="file:{{ $file->id }}" x-model="selected"></label>
                    <button type="button" class="gd-name" wire:click="openPreview({{ $file->id }})">
                        <x-filament::icon :icon="$ikon($file->tipe)" class="t-{{ $file->tipe }}" />
                        <span title="{{ $file->nama }}">{{ $file->nama }}</span>
                    </button>
                    <div class="gd-muted gd-col-own">{{ $file->uploader?->name ?? '-' }}</div>
                    <div class="gd-muted">{{ $file->updated_at->format('d M Y') }}</div>
                    <div class="gd-muted gd-col-size">{{ $file->ukuran_format }}</div>
                    @include('filament.pages.partials.arsip-menu', ['type' => 'file', 'id' => $file->id])
                </div>
            @endforeach
        </div>
    @endif

    {{-- ============ TAMPILAN GRID ============ --}}
    @if ($viewMode === 'grid' && ! $kosong)
        @if ($folders->isNotEmpty())
            <div class="gd-title">Folder</div>
            <div class="gd-folders">
                @foreach ($folders as $folder)
                    <div class="gd-folder" wire:key="gf-{{ $folder->id }}"
                         data-key="folder:{{ $folder->id }}"
                         draggable="true"
                         :class="{ 'sel': selected.includes('folder:{{ $folder->id }}'), 'dragging': dragItems.includes('folder:{{ $folder->id }}'), 'drop': overId === {{ $folder->id }} }"
                         x-on:dragstart="dragStart($event, 'folder:{{ $folder->id }}')"
                         x-on:dragend="reset()"
                         x-on:dragover="dragOver($event, {{ $folder->id }})"
                         x-on:dragleave="leave($event)"
                         x-on:drop="drop($event, {{ $folder->id }})"
                         wire:dblclick="openFolder({{ $folder->id }})">
                        <label class="gd-check"><input type="checkbox" value="folder:{{ $folder->id }}" x-model="selected"></label>
                        <button type="button" class="gd-name" wire:click="openFolder({{ $folder->id }})">
                            <x-filament::icon icon="heroicon-s-folder" class="t-folder" />
                            <span>{{ $folder->nama }}</span>
                        </button>
                        @include('filament.pages.partials.arsip-menu', ['type' => 'folder', 'id' => $folder->id])
                    </div>
                @endforeach
            </div>
        @endif

        @if ($files->isNotEmpty())
            <div class="gd-title">File</div>
            <div class="gd-files">
                @foreach ($files as $file)
                    <div class="gd-card" wire:key="gc-{{ $file->id }}"
                         data-key="file:{{ $file->id }}"
                         draggable="true"
                         :class="{ 'sel': selected.includes('file:{{ $file->id }}'), 'dragging': dragItems.includes('file:{{ $file->id }}') }"
                         x-on:dragstart="dragStart($event, 'file:{{ $file->id }}')"
                         x-on:dragend="reset()">
                        <div class="gd-card-head">
                            <label class="gd-check"><input type="checkbox" value="file:{{ $file->id }}" x-model="selected"></label>
                            <button type="button" class="gd-name" wire:click="openPreview({{ $file->id }})">
                                <x-filament::icon :icon="$ikon($file->tipe)" class="t-{{ $file->tipe }}" />
                                <span title="{{ $file->nama }}">{{ $file->nama }}</span>
                            </button>
                            @include('filament.pages.partials.arsip-menu', ['type' => 'file', 'id' => $file->id])
                        </div>
                        <div class="gd-preview" wire:click="openPreview({{ $file->id }})">
                            <x-filament::icon :icon="$ikon($file->tipe)" class="t-{{ $file->tipe }}" />
                        </div>
                        <div class="gd-card-foot">{{ $file->ukuran_format }} · {{ $file->updated_at->format('d M Y') }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif

    {{-- KOSONG --}}
    @if ($kosong)
        <div class="gd-empty">
            <x-filament::icon icon="heroicon-o-folder-open" />
            <div>
                @if ($search !== '' || $filterJenis !== '')
                    Tidak ada hasil yang cocok.
                @else
                    Folder ini masih kosong.
                @endif
            </div>
        </div>
    @endif

    {{-- MODAL PREVIEW --}}
    @php($pv = $this->getPreviewFile())

    @if ($pv)
        <div class="gd-modal" wire:key="preview-{{ $pv->id }}" x-data x-on:keydown.escape.window="$wire.closePreview()">
            <div class="gd-modal-bar">
                <x-filament::icon :icon="$ikon($pv->tipe)" />
                <div class="gd-modal-title">{{ $pv->nama }}</div>

                <a class="gd-modal-btn" target="_blank"
                   href="{{ match($pv->mode_preview) {
                        'tabel' => route('arsip.tabel', $pv),
                        'pdf-konversi' => route('arsip.pdf', $pv),
                        default => route('arsip.file', $pv),
                   } }}">
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
                @switch($pv->mode_preview)
                    @case('pdf-langsung') <iframe src="{{ route('arsip.file', $pv) }}"></iframe> @break
                    @case('gambar') <img src="{{ route('arsip.file', $pv) }}" alt="{{ $pv->nama }}"> @break
                    @case('tabel') <iframe src="{{ route('arsip.tabel', $pv) }}"></iframe> @break
                    @case('pdf-konversi') <iframe src="{{ route('arsip.pdf', $pv) }}"></iframe> @break
                    @default
                        <div class="gd-nopreview">
                            <x-filament::icon :icon="$ikon($pv->tipe)" />
                            <div style="font-weight:500;margin-bottom:6px">Preview tidak tersedia</div>
                            <div style="font-size:13px;color:var(--gd-muted);margin-bottom:18px">Format file ini tidak dapat ditampilkan. Silakan download.</div>
                            <a class="gd-modal-btn" style="background:#1a73e8" href="{{ route('arsip.file', ['file' => $pv, 'unduh' => 1]) }}">
                                <x-filament::icon icon="heroicon-o-arrow-down-tray" /> Download file
                            </a>
                        </div>
                @endswitch
            </div>
        </div>
    @endif

    {{-- OVERLAY SERET-LEPAS --}}
    <div class="gd-dropzone" x-show="dropActive" x-cloak>
        <div class="gd-dropzone-pill">
            <x-filament::icon icon="heroicon-s-cloud-arrow-up" />
            <div>Lepas file untuk mengunggahnya</div>
            <strong x-text="overId && overId !== 'root' ? 'ke folder yang disorot' : '{{ $this->getCurrentFolder()?->nama ?? 'Arsip Laporan' }}'"></strong>
        </div>
    </div>

    {{-- PROGRES UPLOAD --}}
    <div class="gd-upl" x-show="uploading" x-cloak>
        <div x-text="upInfo"></div>
        <div class="gd-upl-bar"><div :style="'width:' + progress + '%'"></div></div>
    </div>

</div>

</x-filament-panels::page>