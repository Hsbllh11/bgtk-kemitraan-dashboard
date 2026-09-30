@extends('layouts.public')

@section('title', 'Data Kemitraan | BGTK NTB')

@section('description', 'Data kemitraan BGTK Nusa Tenggara Barat.')

@section('content')

{{-- HEADER --}}
<section class="bg-slate-950">

    <div class="mx-auto max-w-7xl px-6 py-20">

        <div class="max-w-3xl">

            <div class="text-sm font-semibold uppercase tracking-wider text-blue-400">
                Data Kemitraan
            </div>

            <h1 class="mt-3 text-4xl font-bold text-white sm:text-5xl">
                Informasi Kemitraan
            </h1>

            <p class="mt-5 text-lg leading-8 text-slate-300">
                Informasi anggota dan mitra yang terdaftar dalam
                sistem kemitraan BGTK Nusa Tenggara Barat.
            </p>

        </div>

    </div>

</section>


{{-- STATISTIK --}}
<section class="bg-white">

    <div class="mx-auto max-w-7xl px-6 py-12">

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

            <div class="rounded-2xl border border-slate-200 p-6 shadow-sm">
                <p class="text-sm text-slate-500">
                    Total Keanggotaan
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ number_format($totalKeanggotaan, 0, ',', '.') }}
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 p-6 shadow-sm">
                <p class="text-sm text-slate-500">
                    Keanggotaan Aktif
                </p>

                <p class="mt-2 text-3xl font-bold text-green-600">
                    {{ number_format($totalKeanggotaanAktif, 0, ',', '.') }}
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 p-6 shadow-sm">
                <p class="text-sm text-slate-500">
                    Total Mitra
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ number_format($totalMitra, 0, ',', '.') }}
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 p-6 shadow-sm">
                <p class="text-sm text-slate-500">
                    Mitra Aktif
                </p>

                <p class="mt-2 text-3xl font-bold text-blue-600">
                    {{ number_format($totalMitraAktif, 0, ',', '.') }}
                </p>
            </div>

        </div>

    </div>

</section>


{{-- FILTER --}}
<section class="bg-slate-50">

    <div class="mx-auto max-w-7xl px-6 py-10">

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="mb-5">

                <h2 class="text-lg font-bold text-slate-900">
                    Cari dan Filter Data
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Gunakan pencarian atau filter untuk menemukan data
                    kemitraan.
                </p>

            </div>

            <form
                method="GET"
                action="{{ route('kemitraan') }}"
                class="grid gap-4 md:grid-cols-2 lg:grid-cols-4"
            >

                {{-- SEARCH --}}
                <div class="lg:col-span-2">

                    <label
                        for="search"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Pencarian
                    </label>

                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Cari nama, instansi, jabatan..."
                        class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                </div>


                {{-- KABUPATEN --}}
                <div>

                    <label
                        for="kabupaten_kota"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Kabupaten / Kota
                    </label>

                    <select
                        id="kabupaten_kota"
                        name="kabupaten_kota"
                        class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                        <option value="">
                            Semua Kabupaten / Kota
                        </option>

                        @foreach($kabupatenKotas as $kabupaten)
                            <option
                                value="{{ $kabupaten }}"
                                @selected($selectedKabupatenKota === $kabupaten)
                            >
                                {{ $kabupaten }}
                            </option>
                        @endforeach

                    </select>

                </div>


                {{-- STATUS --}}
                <div>

                    <label
                        for="status"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                        <option value="">
                            Semua Status
                        </option>

                        @foreach($statuses as $item)
                            <option
                                value="{{ $item }}"
                                @selected($selectedStatus === $item)
                            >
                                {{ $item }}
                            </option>
                        @endforeach

                    </select>

                </div>


                {{-- BUTTON --}}
                <div class="flex items-end gap-3 md:col-span-2 lg:col-span-4">

                    <button
                        type="submit"
                        class="rounded-xl bg-blue-700 px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-800"
                    >
                        Terapkan Filter
                    </button>

                    <a
                        href="{{ route('kemitraan') }}"
                        class="rounded-xl border border-slate-300 bg-white px-6 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                    >
                        Reset
                    </a>

                </div>

            </form>

        </div>

    </div>

</section>


{{-- DATA KEANGGOTAAN --}}
<section class="bg-slate-50">

    <div class="mx-auto max-w-7xl px-6 pb-12">

        <div class="mb-5">

            <h2 class="text-2xl font-bold text-slate-900">
                Data Keanggotaan
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Daftar anggota kemitraan yang tersedia dalam sistem.
            </p>

        </div>


        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="w-full min-w-[1000px] text-left text-sm">

                    <thead class="bg-slate-100 text-xs uppercase tracking-wide text-slate-600">

                        <tr>
                            <th class="px-5 py-4">No</th>
                            <th class="px-5 py-4">Nama</th>
                            <th class="px-5 py-4">Instansi</th>
                            <th class="px-5 py-4">Kabupaten / Kota</th>
                            <th class="px-5 py-4">Jenis Mitra</th>
                            <th class="px-5 py-4">Peran</th>
                            <th class="px-5 py-4">Status</th>
                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse($keanggotaans as $index => $item)

                            <tr class="transition hover:bg-slate-50">

                                <td class="px-5 py-4 text-slate-500">
                                    {{ $keanggotaans->firstItem() + $index }}
                                </td>

                                <td class="px-5 py-4">

                                    <div class="font-semibold text-slate-900">
                                        {{ $item->nama }}
                                    </div>

                                    @if($item->nip_nik)
                                        <div class="mt-1 text-xs text-slate-500">
                                            {{ $item->nip_nik }}
                                        </div>
                                    @endif

                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    {{ $item->instansi }}
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    {{ $item->kabupaten_kota }}
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    {{ $item->jenis_mitra }}
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    {{ $item->peran }}
                                </td>

                                <td class="px-5 py-4">

                                    @if($item->status === 'Aktif')

                                        <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                            Aktif
                                        </span>

                                    @else

                                        <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                            {{ $item->status ?: 'Tidak diketahui' }}
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td
                                    colspan="7"
                                    class="px-5 py-12 text-center text-slate-500"
                                >
                                    Tidak ada data keanggotaan yang ditemukan.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            @if($keanggotaans->hasPages())

                <div class="border-t border-slate-200 px-5 py-4">
                    {{ $keanggotaans->links() }}
                </div>

            @endif

        </div>

    </div>

</section>


{{-- DATA MITRA --}}
<section class="bg-white">

    <div class="mx-auto max-w-7xl px-6 py-12">

        <div class="mb-5">

            <h2 class="text-2xl font-bold text-slate-900">
                Data Mitra
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Daftar mitra yang terdaftar dalam sistem kemitraan.
            </p>

        </div>


        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="w-full min-w-[950px] text-left text-sm">

                    <thead class="bg-slate-100 text-xs uppercase tracking-wide text-slate-600">

                        <tr>
                            <th class="px-5 py-4">No</th>
                            <th class="px-5 py-4">Nama Mitra</th>
                            <th class="px-5 py-4">Jenis Mitra</th>
                            <th class="px-5 py-4">Instansi</th>
                            <th class="px-5 py-4">Kabupaten / Kota</th>
                            <th class="px-5 py-4">Kontak</th>
                            <th class="px-5 py-4">Status</th>
                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse($mitras as $index => $item)

                            <tr class="transition hover:bg-slate-50">

                                <td class="px-5 py-4 text-slate-500">
                                    {{ $mitras->firstItem() + $index }}
                                </td>

                                <td class="px-5 py-4 font-semibold text-slate-900">
                                    {{ $item->nama_mitra }}
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    {{ $item->jenis_mitra }}
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    {{ $item->instansi ?: '-' }}
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    {{ $item->kabupaten_kota }}
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    {{ $item->kontak ?: '-' }}
                                </td>

                                <td class="px-5 py-4">

                                    @if($item->status === 'Aktif')

                                        <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                            Aktif
                                        </span>

                                    @else

                                        <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                            {{ $item->status ?: 'Tidak diketahui' }}
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td
                                    colspan="7"
                                    class="px-5 py-12 text-center text-slate-500"
                                >
                                    Tidak ada data mitra yang ditemukan.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            @if($mitras->hasPages())

                <div class="border-t border-slate-200 px-5 py-4">
                    {{ $mitras->links() }}
                </div>

            @endif

        </div>

    </div>

</section>

@endsection