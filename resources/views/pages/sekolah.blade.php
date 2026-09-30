@extends('layouts.public')

@section('title', 'Data Sekolah')

@section('content')

<section class="bg-[#020617] text-white">
    <div class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
        <h1 class="text-4xl font-bold tracking-tight">
            Data Sekolah
        </h1>

        <p class="mt-4 max-w-2xl text-slate-300">
            Informasi data sekolah dan kebutuhan kepala sekolah
            di Provinsi Nusa Tenggara Barat.
        </p>
    </div>
</section>

<section class="bg-slate-50">
    <div class="mx-auto max-w-7xl px-6 py-16 lg:px-8">

        {{-- Statistik --}}
        <div class="grid gap-5 md:grid-cols-3">

            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm font-medium text-slate-500">
                    Total Data Sekolah
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ number_format($totalSekolah) }}
                </p>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm font-medium text-slate-500">
                    Valid Mapping
                </p>

                <p class="mt-2 text-3xl font-bold text-blue-600">
                    {{ number_format($totalValid) }}
                </p>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm font-medium text-slate-500">
                    Unmapped
                </p>

                <p class="mt-2 text-3xl font-bold text-amber-600">
                    {{ number_format($totalUnmapped) }}
                </p>
            </div>

        </div>

        {{-- Filter --}}
        <div class="mt-8 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">

            <form
                method="GET"
                action="{{ route('sekolah') }}"
                class="grid gap-4 md:grid-cols-2 lg:grid-cols-4"
            >

                <div class="lg:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Cari sekolah / kepala sekolah
                    </label>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Masukkan kata pencarian..."
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
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
                        Status KS
                    </label>

                    <select
                        name="status_ks"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                        <option value="">
                            Semua Status
                        </option>

                        @foreach ($statusKs as $status)
                            <option
                                value="{{ $status }}"
                                @selected(request('status_ks') === $status)
                            >
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Pemetaan
                    </label>

                    <select
                        name="pemetaan"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                        <option value="">
                            Semua Pemetaan
                        </option>

                        @foreach ($pemetaan as $item)
                            <option
                                value="{{ $item }}"
                                @selected(request('pemetaan') === $item)
                            >
                                {{ $item }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-3 lg:col-span-3">
                    <button
                        type="submit"
                        class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700"
                    >
                        Terapkan Filter
                    </button>

                    <a
                        href="{{ route('sekolah') }}"
                        class="rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                    >
                        Reset
                    </a>
                </div>

            </form>
        </div>

        {{-- Tabel --}}
        <div class="mt-8 overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">

            <div class="border-b border-slate-200 px-6 py-5">
                <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">
                            Data Sekolah
                        </h2>

                        <p class="text-sm text-slate-500">
                            Menampilkan
                            {{ $sekolahs->firstItem() ?? 0 }}
                            -
                            {{ $sekolahs->lastItem() ?? 0 }}
                            dari
                            {{ number_format($sekolahs->total()) }}
                            data.
                        </p>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">

                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                No
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Nama Sekolah
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Kepala Sekolah
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Kabupaten / Kota
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Status KS
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Status Sekolah
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Pemetaan
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse ($sekolahs as $index => $sekolah)

                            <tr class="transition hover:bg-slate-50">

                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500">
                                    {{ $sekolahs->firstItem() + $index }}
                                </td>

                                <td class="px-6 py-4">
                                    <p class="font-semibold text-slate-900">
                                        {{ $sekolah->nama_sekolah }}
                                    </p>

                                    @if ($sekolah->lokasi_sekolah)
                                        <p class="mt-1 text-xs text-slate-500">
                                            {{ $sekolah->lokasi_sekolah }}
                                        </p>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-700">
                                    {{ $sekolah->nama_kepala_sekolah ?: '-' }}
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-700">
                                    {{ $sekolah->kabupaten_kota }}
                                </td>

                                <td class="px-6 py-4">
                                    <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                        {{ $sekolah->status_ks ?: '-' }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-700">
                                    {{ $sekolah->status_sekolah ?: '-' }}
                                </td>

                                <td class="px-6 py-4">

                                    @if ($sekolah->pemetaan === 'VALID_MAPPING')

                                        <span class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                                            VALID MAPPING
                                        </span>

                                    @elseif ($sekolah->pemetaan === 'UNMAPPED')

                                        <span class="inline-flex rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">
                                            UNMAPPED
                                        </span>

                                    @else

                                        <span class="text-sm text-slate-500">
                                            -
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td
                                    colspan="7"
                                    class="px-6 py-12 text-center text-sm text-slate-500"
                                >
                                    Tidak ada data yang sesuai dengan filter.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

            @if ($sekolahs->hasPages())

                <div class="border-t border-slate-200 px-6 py-5">
                    {{ $sekolahs->links() }}
                </div>

            @endif

        </div>

    </div>
</section>

@endsection