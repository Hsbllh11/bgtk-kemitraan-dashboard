@extends('layouts.public')

@section('title', 'Kegiatan')

@section('content')

<section class="bg-[#020617] text-white">
    <div class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
        <h1 class="text-4xl font-bold tracking-tight">
            Kegiatan
        </h1>

        <p class="mt-4 max-w-2xl text-slate-300">
            Informasi kegiatan BGTK Nusa Tenggara Barat.
        </p>
    </div>
</section>

<section class="bg-slate-50">
    <div class="mx-auto max-w-7xl px-6 py-16 lg:px-8">

        <div class="grid gap-5 md:grid-cols-3">

            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm font-medium text-slate-500">
                    Total Kegiatan
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ number_format($totalKegiatan) }}
                </p>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm font-medium text-slate-500">
                    Berlangsung
                </p>

                <p class="mt-2 text-3xl font-bold text-blue-600">
                    {{ number_format($kegiatanBerlangsung) }}
                </p>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm font-medium text-slate-500">
                    Selesai
                </p>

                <p class="mt-2 text-3xl font-bold text-emerald-600">
                    {{ number_format($kegiatanSelesai) }}
                </p>
            </div>

        </div>

        <div class="mt-8 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">

            <form
                method="GET"
                action="{{ route('kegiatan') }}"
                class="grid gap-4 md:grid-cols-2 lg:grid-cols-4"
            >

                <div class="lg:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Cari Kegiatan
                    </label>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Nama kegiatan, jenis, lokasi..."
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Kabupaten / Kota
                    </label>

                    <select
                        name="kabupaten_kota"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                        <option value="">
                            Semua Kabupaten / Kota
                        </option>

                        @foreach ($kabupatenKota as $kabupaten)
                            <option
                                value="{{ $kabupaten }}"
                                @selected(request('kabupaten_kota') === $kabupaten)
                            >
                                {{ $kabupaten }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Status
                    </label>

                    <select
                        name="status"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                        <option value="">
                            Semua Status
                        </option>

                        @foreach ($statuses as $status)
                            <option
                                value="{{ $status }}"
                                @selected(request('status') === $status)
                            >
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-3 lg:col-span-4">
                    <button
                        type="submit"
                        class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700"
                    >
                        Terapkan Filter
                    </button>

                    <a
                        href="{{ route('kegiatan') }}"
                        class="rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                    >
                        Reset
                    </a>
                </div>

            </form>

        </div>

        <div class="mt-8 overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">

            <div class="border-b border-slate-200 px-6 py-5">
                <h2 class="text-lg font-bold text-slate-900">
                    Daftar Kegiatan
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    {{ number_format($kegiatans->total()) }} kegiatan ditemukan.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">

                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                No
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Kegiatan
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Jenis
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Kabupaten / Kota
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Lokasi
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Tanggal
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Penanggung Jawab
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Status
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse ($kegiatans as $index => $kegiatan)

                            <tr class="hover:bg-slate-50">

                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500">
                                    {{ $kegiatans->firstItem() + $index }}
                                </td>

                                <td class="px-6 py-4">
                                    <p class="font-semibold text-slate-900">
                                        {{ $kegiatan->nama_kegiatan }}
                                    </p>

                                    @if ($kegiatan->keterangan)
                                        <p class="mt-1 max-w-md text-xs text-slate-500">
                                            {{ $kegiatan->keterangan }}
                                        </p>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-700">
                                    {{ $kegiatan->jenis_kegiatan }}
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-700">
                                    {{ $kegiatan->kabupaten_kota }}
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-700">
                                    {{ $kegiatan->lokasi ?: '-' }}
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-700">
                                    {{ $kegiatan->tanggal_mulai?->format('d/m/Y') ?: '-' }}

                                    @if ($kegiatan->tanggal_selesai)
                                        <span class="text-slate-400">-</span>
                                        {{ $kegiatan->tanggal_selesai->format('d/m/Y') }}
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-700">
                                    {{ $kegiatan->penanggung_jawab ?: '-' }}
                                </td>

                                <td class="px-6 py-4">
                                    <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                        {{ $kegiatan->status ?: '-' }}
                                    </span>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-sm text-slate-500">
                                    Belum ada data kegiatan.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

            @if ($kegiatans->hasPages())
                <div class="border-t border-slate-200 px-6 py-5">
                    {{ $kegiatans->links() }}
                </div>
            @endif

        </div>

    </div>
</section>

@endsection