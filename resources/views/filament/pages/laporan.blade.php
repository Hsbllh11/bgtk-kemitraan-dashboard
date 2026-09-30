<x-filament-panels::page>

    <div class="mb-6 flex flex-wrap gap-3">

    <x-filament::button
        wire:click="exportExcel"
        icon="heroicon-m-arrow-down-tray"
    >
        Export Excel
    </x-filament::button>

    <x-filament::button
        wire:click="exportPdf"
        color="gray"
        icon="heroicon-m-document-arrow-down"
    >
        Export PDF
    </x-filament::button>

    </div>

    {{-- ========================================================= --}}
    {{-- FILTER LAPORAN --}}
    {{-- ========================================================= --}}

    <x-filament::section>
        <x-slot name="heading">
            Filter Laporan
        </x-slot>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

            {{-- Kabupaten / Kota --}}
            <div>
                <label class="mb-2 block text-sm font-medium">
                    Kabupaten / Kota
                </label>

                <select
                    wire:model.live="kabupatenKota"
                    class="mb-4 w-full rounded-lg border-gray-300 bg-white shadow-sm"
                >
                    <option value="">Semua Kabupaten / Kota</option>

                    @foreach ($this->getKabupatenKotaOptions() as $value => $label)
                        <option value="{{ $value }}">
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Status --}}
            <div>
                <label class="mb-2 block text-sm font-medium">
                    Status
                </label>

                <select
                    wire:model.live="status"
                    class="w-full rounded-lg border-gray-300 bg-white shadow-sm"
                >
                    <option value="">Semua Status</option>

                    @foreach ($this->getStatusOptions() as $value => $label)
                        <option value="{{ $value }}">
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        {{-- Reset --}}
        <div class="mt-4">
            <x-filament::button
                wire:click="resetFilter"
                color="primary"
                icon="heroicon-m-arrow-path"
            >
                Reset Filter
            </x-filament::button>
        </div>

    </x-filament::section>


    {{-- ========================================================= --}}
    {{-- RINGKASAN --}}
    {{-- ========================================================= --}}

    <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">

        {{-- Keanggotaan --}}
        <x-filament::section class="h-full p-4">
            <div class="text-sm text-gray-500">
                Total Keanggotaan
            </div>

            <div class="mt-2 text-3xl font-bold">
                {{
                    \App\Models\Keanggotaan::query()
                        ->when($kabupatenKota, function ($query) use ($kabupatenKota) {
                            $query->where('kabupaten_kota', $kabupatenKota);
                        })
                        ->when($status, function ($query) use ($status) {
                            $query->where('status', $status);
                        })
                        ->count()
                }}
            </div>
        </x-filament::section>


        {{-- Mitra --}}
        <x-filament::section class="h-full p-4">
            <div class="text-sm text-gray-500">
                Total Mitra
            </div>

            <div class="mt-2 text-3xl font-bold">
                {{
                    \App\Models\Mitra::query()
                        ->when($kabupatenKota, function ($query) use ($kabupatenKota) {
                            $query->where('kabupaten_kota', $kabupatenKota);
                        })
                        ->when($status, function ($query) use ($status) {
                            $query->where('status', $status);
                        })
                        ->count()
                }}
            </div>
        </x-filament::section>


        {{-- Kegiatan --}}
        <x-filament::section class="h-full p-4">
            <div class="text-sm text-gray-500">
                Total Kegiatan
            </div>

            <div class="mt-2 text-3xl font-bold">
                {{
                    \App\Models\Kegiatan::query()
                        ->when($kabupatenKota, function ($query) use ($kabupatenKota) {
                            $query->where('kabupaten_kota', $kabupatenKota);
                        })
                        ->when($status, function ($query) use ($status) {
                            $query->where('status', $status);
                        })
                        ->count()
                }}
            </div>
        </x-filament::section>


        {{-- Program --}}
        <x-filament::section class="h-full p-4">
            <div class="text-sm text-gray-500">
                Total Program
            </div>

            <div class="mt-2 text-3xl font-bold">
                {{
                    \App\Models\Program::query()
                        ->when($kabupatenKota, function ($query) use ($kabupatenKota) {
                            $query->where('kabupaten_kota', $kabupatenKota);
                        })
                        ->when($status, function ($query) use ($status) {
                            $query->where('status', $status);
                        })
                        ->count()
                }}
            </div>
        </x-filament::section>

    </div>


    {{-- ========================================================= --}}
    {{-- REKAP KEANGGOTAAN --}}
    {{-- ========================================================= --}}

    <div class="mt-6">

        <x-filament::section>

            <x-slot name="heading">
                Rekap Data Keanggotaan
            </x-slot>

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="px-4 py-3 text-left">No</th>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left">Instansi</th>
                            <th class="px-4 py-3 text-left">
                                Kabupaten / Kota
                            </th>
                            <th class="px-4 py-3 text-left">
                                Jenis Mitra
                            </th>
                            <th class="px-4 py-3 text-left">
                                Peran
                            </th>
                            <th class="px-4 py-3 text-left">
                                Status
                            </th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse (
                            \App\Models\Keanggotaan::query()
                                ->when($kabupatenKota, function ($query) use ($kabupatenKota) {
                                    $query->where('kabupaten_kota', $kabupatenKota);
                                })
                                ->when($status, function ($query) use ($status) {
                                    $query->where('status', $status);
                                })
                                ->orderBy('nama')
                                ->get()
                            as $index => $keanggotaan
                        )

                            <tr class="border-b hover:bg-gray-50">

                                <td class="px-4 py-3">
                                    {{ $index + 1 }}
                                </td>

                                <td class="px-4 py-3 font-medium">
                                    {{ $keanggotaan->nama }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $keanggotaan->instansi }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $keanggotaan->kabupaten_kota }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $keanggotaan->jenis_mitra }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $keanggotaan->peran }}
                                </td>

                                <td class="px-4 py-3">

                                    @if ($keanggotaan->status === 'Aktif')

                                        <x-filament::badge color="success">
                                            Aktif
                                        </x-filament::badge>

                                    @else

                                        <x-filament::badge color="gray">
                                            {{ $keanggotaan->status }}
                                        </x-filament::badge>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td
                                    colspan="7"
                                    class="px-4 py-8 text-center text-gray-500"
                                >
                                    Tidak ada data keanggotaan.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </x-filament::section>

    </div>


    {{-- ========================================================= --}}
    {{-- REKAP MITRA --}}
    {{-- ========================================================= --}}

    <div class="mt-6">

        <x-filament::section>

            <x-slot name="heading">
                Rekap Data Mitra
            </x-slot>

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="px-4 py-3 text-left">No</th>
                            <th class="px-4 py-3 text-left">
                                Nama Mitra
                            </th>
                            <th class="px-4 py-3 text-left">
                                Jenis Mitra
                            </th>
                            <th class="px-4 py-3 text-left">
                                Instansi
                            </th>
                            <th class="px-4 py-3 text-left">
                                Kabupaten / Kota
                            </th>
                            <th class="px-4 py-3 text-left">
                                Kontak
                            </th>
                            <th class="px-4 py-3 text-left">
                                Status
                            </th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse (
                            \App\Models\Mitra::query()
                                ->when($kabupatenKota, function ($query) use ($kabupatenKota) {
                                    $query->where('kabupaten_kota', $kabupatenKota);
                                })
                                ->when($status, function ($query) use ($status) {
                                    $query->where('status', $status);
                                })
                                ->orderBy('nama_mitra')
                                ->get()
                            as $index => $mitra
                        )

                            <tr class="border-b hover:bg-gray-50">

                                <td class="px-4 py-3">
                                    {{ $index + 1 }}
                                </td>

                                <td class="px-4 py-3 font-medium">
                                    {{ $mitra->nama_mitra }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $mitra->jenis_mitra }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $mitra->instansi }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $mitra->kabupaten_kota }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $mitra->kontak }}
                                </td>

                                <td class="px-4 py-3">

                                    @if ($mitra->status === 'Aktif')

                                        <x-filament::badge color="success">
                                            Aktif
                                        </x-filament::badge>

                                    @elseif ($mitra->status === 'Nonaktif')

                                        <x-filament::badge color="danger">
                                            Nonaktif
                                        </x-filament::badge>

                                    @else

                                        <x-filament::badge color="gray">
                                            {{ $mitra->status }}
                                        </x-filament::badge>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td
                                    colspan="7"
                                    class="px-4 py-8 text-center text-gray-500"
                                >
                                    Tidak ada data mitra.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </x-filament::section>

    </div>


    {{-- ========================================================= --}}
    {{-- REKAP KEGIATAN --}}
    {{-- ========================================================= --}}

    <div class="mt-6">

        <x-filament::section>

            <x-slot name="heading">
                Rekap Data Kegiatan
            </x-slot>

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="px-4 py-3 text-left">No</th>
                            <th class="px-4 py-3 text-left">
                                Nama Kegiatan
                            </th>
                            <th class="px-4 py-3 text-left">
                                Jenis Kegiatan
                            </th>
                            <th class="px-4 py-3 text-left">
                                Kabupaten / Kota
                            </th>
                            <th class="px-4 py-3 text-left">
                                Lokasi
                            </th>
                            <th class="px-4 py-3 text-left">
                                Tanggal Mulai
                            </th>
                            <th class="px-4 py-3 text-left">
                                Tanggal Selesai
                            </th>
                            <th class="px-4 py-3 text-left">
                                Status
                            </th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse (
                            \App\Models\Kegiatan::query()
                                ->when($kabupatenKota, function ($query) use ($kabupatenKota) {
                                    $query->where('kabupaten_kota', $kabupatenKota);
                                })
                                ->when($status, function ($query) use ($status) {
                                    $query->where('status', $status);
                                })
                                ->orderBy('tanggal_mulai', 'desc')
                                ->get()
                            as $index => $kegiatan
                        )

                            <tr class="border-b hover:bg-gray-50">

                                <td class="px-4 py-3">
                                    {{ $index + 1 }}
                                </td>

                                <td class="px-4 py-3 font-medium">
                                    {{ $kegiatan->nama_kegiatan }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $kegiatan->jenis_kegiatan }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $kegiatan->kabupaten_kota }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $kegiatan->lokasi }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $kegiatan->tanggal_mulai?->format('d M Y') }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $kegiatan->tanggal_selesai?->format('d M Y') }}
                                </td>

                                <td class="px-4 py-3">

                                    @if ($kegiatan->status === 'Berlangsung')

                                        <x-filament::badge color="info">
                                            Berlangsung
                                        </x-filament::badge>

                                    @elseif ($kegiatan->status === 'Selesai')

                                        <x-filament::badge color="success">
                                            Selesai
                                        </x-filament::badge>

                                    @elseif ($kegiatan->status === 'Dibatalkan')

                                        <x-filament::badge color="danger">
                                            Dibatalkan
                                        </x-filament::badge>

                                    @else

                                        <x-filament::badge color="warning">
                                            {{ $kegiatan->status }}
                                        </x-filament::badge>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td
                                    colspan="8"
                                    class="px-4 py-8 text-center text-gray-500"
                                >
                                    Tidak ada data kegiatan.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </x-filament::section>

    </div>


    {{-- ========================================================= --}}
    {{-- REKAP PROGRAM --}}
    {{-- ========================================================= --}}

    <div class="mt-6">

        <x-filament::section>

            <x-slot name="heading">
                Rekap Data Program
            </x-slot>

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="px-4 py-3 text-left">No</th>
                            <th class="px-4 py-3 text-left">
                                Nama Program
                            </th>
                            <th class="px-4 py-3 text-left">
                                Jenis Program
                            </th>
                            <th class="px-4 py-3 text-left">
                                Kabupaten / Kota
                            </th>
                            <th class="px-4 py-3 text-left">
                                Penanggung Jawab
                            </th>
                            <th class="px-4 py-3 text-left">
                                Tanggal Mulai
                            </th>
                            <th class="px-4 py-3 text-left">
                                Tanggal Selesai
                            </th>
                            <th class="px-4 py-3 text-left">
                                Status
                            </th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse (
                            \App\Models\Program::query()
                                ->when($kabupatenKota, function ($query) use ($kabupatenKota) {
                                    $query->where('kabupaten_kota', $kabupatenKota);
                                })
                                ->when($status, function ($query) use ($status) {
                                    $query->where('status', $status);
                                })
                                ->orderBy('tanggal_mulai', 'desc')
                                ->get()
                            as $index => $program
                        )

                            <tr class="border-b hover:bg-gray-50">

                                <td class="px-4 py-3">
                                    {{ $index + 1 }}
                                </td>

                                <td class="px-4 py-3 font-medium">
                                    {{ $program->nama_program }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $program->jenis_program }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $program->kabupaten_kota }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $program->penanggung_jawab }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $program->tanggal_mulai?->format('d M Y') }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $program->tanggal_selesai?->format('d M Y') }}
                                </td>

                                <td class="px-4 py-3">

                                    @if ($program->status === 'Berlangsung')

                                        <x-filament::badge color="info">
                                            Berlangsung
                                        </x-filament::badge>

                                    @elseif ($program->status === 'Selesai')

                                        <x-filament::badge color="success">
                                            Selesai
                                        </x-filament::badge>

                                    @elseif ($program->status === 'Dibatalkan')

                                        <x-filament::badge color="danger">
                                            Dibatalkan
                                        </x-filament::badge>

                                    @else

                                        <x-filament::badge color="warning">
                                            {{ $program->status }}
                                        </x-filament::badge>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td
                                    colspan="8"
                                    class="px-4 py-8 text-center text-gray-500"
                                >
                                    Tidak ada data program.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </x-filament::section>

    </div>

</x-filament-panels::page>