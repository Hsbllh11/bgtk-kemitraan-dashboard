@php
    $isFolder = $type === 'folder';
    $key = $type . ':' . $id;
@endphp

<div class="gd-menu" x-data="{ open: false }" x-on:click.outside="open = false" x-on:keydown.escape.window="open = false">
    <button type="button" class="gd-dots" x-on:click.stop="open = !open" title="Opsi lainnya">
        <x-filament::icon icon="heroicon-m-ellipsis-vertical" />
    </button>

    <div class="gd-menu-list" x-show="open" x-cloak x-transition.opacity x-on:click="open = false">
        @if ($isFolder)
            <button type="button" wire:click="openFolder({{ $id }})">
                <x-filament::icon icon="heroicon-o-folder-open" /> Buka
            </button>
        @else
            <button type="button" wire:click="openPreview({{ $id }})">
                <x-filament::icon icon="heroicon-o-eye" /> Lihat
            </button>
            <a href="{{ route('arsip.file', ['file' => $id, 'unduh' => 1]) }}">
                <x-filament::icon icon="heroicon-o-arrow-down-tray" /> Download
            </a>
        @endif

        <button type="button" wire:click="mountAction('rename', { type: '{{ $type }}', id: {{ $id }} })">
            <x-filament::icon icon="heroicon-o-pencil" /> Ganti nama
        </button>

        {{-- Jika item ini termasuk yang dipilih, semua yang dipilih ikut dipindah --}}
        <button type="button"
                x-on:click="$wire.pindahkan(selected.includes('{{ $key }}') ? selected : ['{{ $key }}'])">
            <x-filament::icon icon="heroicon-o-arrow-right-circle" /> Pindahkan ke...
        </button>

        <button type="button"
                x-on:click="$wire.copyItems(selected.includes('{{ $key }}') ? selected : ['{{ $key }}'], $wire.folderId)">
            <x-filament::icon icon="heroicon-o-document-duplicate" /> Buat salinan
        </button>

        <button type="button"
                x-on:click="$wire.salin(selected.includes('{{ $key }}') ? selected : ['{{ $key }}'])">
            <x-filament::icon icon="heroicon-o-clipboard-document" /> Salin ke...
        </button>

        <hr>

        <button type="button" class="danger"
                wire:click="mountAction('{{ $isFolder ? 'deleteFolder' : 'deleteFile' }}', { id: {{ $id }} })">
            <x-filament::icon icon="heroicon-o-trash" /> Hapus
        </button>
    </div>
</div>