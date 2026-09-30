@extends('layouts.public')

@section('title', 'Beranda')

@section('content')

<!-- HERO -->
<section class="relative overflow-hidden bg-slate-950">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-950 via-slate-950 to-slate-900"></div>

    <div class="relative mx-auto max-w-7xl px-6 py-20 lg:px-8 lg:py-28">
        <div class="max-w-3xl">

            <div class="mb-6 inline-flex items-center rounded-full border border-blue-400/30 bg-blue-500/10 px-4 py-2 text-sm font-medium text-blue-300">
                BGTK Provinsi Nusa Tenggara Barat
            </div>

            <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl">
                Dashboard Kemitraan
                <span class="block text-blue-400">
                    BGTK NTB
                </span>
            </h1>

            <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-300">
                Sistem informasi untuk menyajikan data kemitraan,
                sekolah, program, dan kegiatan secara terintegrasi
                dalam satu platform.
            </p>

            <div class="mt-8 flex flex-wrap gap-4">
                <a
                    href="{{ route('kemitraan') }}"
                    class="rounded-lg bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-500"
                >
                    Lihat Data Kemitraan
                </a>

                <a
                    href="{{ url('/admin') }}"
                    class="rounded-lg border border-slate-600 bg-white/5 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10"
                >
                    Buka Dashboard
                </a>
            </div>

        </div>
    </div>
</section>


<!-- STATISTIK UTAMA -->
<section class="bg-slate-50 py-14">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">

        <div class="mb-10">
            <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">
                Data Terintegrasi
            </p>

            <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">
                Ringkasan Data
            </h2>

            <p class="mt-3 max-w-2xl text-slate-600">
                Data ditampilkan secara langsung berdasarkan informasi
                yang tersimpan dalam sistem.
            </p>
        </div>


        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-5">

            <!-- Keanggotaan -->
            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <div class="flex items-center justify-between">
                    <div class="rounded-xl bg-blue-50 p-3 text-blue-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M15 19a4 4 0 00-8 0m4-8a4 4 0 100-8 4 4 0 000 8zm8 8a4 4 0 00-3-3.87M17 3.13a4 4 0 010 7.75"/>
                        </svg>
                    </div>
                </div>

                <p class="mt-5 text-3xl font-bold text-slate-900">
                    {{ number_format($stats['keanggotaan']) }}
                </p>

                <p class="mt-1 text-sm font-medium text-slate-600">
                    Keanggotaan
                </p>

                <p class="mt-2 text-xs text-emerald-600">
                    {{ number_format($keanggotaanAktif) }} aktif
                </p>
            </div>


            <!-- Mitra -->
            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <div class="rounded-xl bg-emerald-50 p-3 text-emerald-600 w-fit">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M3 21h18M5 21V5a2 2 0 012-2h10a2 2 0 012 2v16M9 7h2m-2 4h2m-2 4h2m4-8h1m-1 4h1m-1 4h1"/>
                    </svg>
                </div>

                <p class="mt-5 text-3xl font-bold text-slate-900">
                    {{ number_format($stats['mitra']) }}
                </p>

                <p class="mt-1 text-sm font-medium text-slate-600">
                    Mitra
                </p>

                <p class="mt-2 text-xs text-emerald-600">
                    {{ number_format($mitraAktif) }} aktif
                </p>
            </div>


            <!-- Sekolah -->
            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <div class="rounded-xl bg-amber-50 p-3 text-amber-600 w-fit">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M3 10l9-6 9 6M5 10v10h14V10M9 20v-6h6v6"/>
                    </svg>
                </div>

                <p class="mt-5 text-3xl font-bold text-slate-900">
                    {{ number_format($stats['sekolah']) }}
                </p>

                <p class="mt-1 text-sm font-medium text-slate-600">
                    Data Sekolah
                </p>

                <p class="mt-2 text-xs text-blue-600">
                    {{ number_format($sekolahValid) }} valid mapping
                </p>
            </div>


            <!-- Program -->
            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <div class="rounded-xl bg-violet-50 p-3 text-violet-600 w-fit">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z"/>
                    </svg>
                </div>

                <p class="mt-5 text-3xl font-bold text-slate-900">
                    {{ number_format($stats['program']) }}
                </p>

                <p class="mt-1 text-sm font-medium text-slate-600">
                    Program
                </p>

                <p class="mt-2 text-xs text-violet-600">
                    {{ number_format($programBerlangsung) }} berlangsung
                </p>
            </div>


            <!-- Kegiatan -->
            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <div class="rounded-xl bg-rose-50 p-3 text-rose-600 w-fit">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M8 7V3m8 4V3M4 9h16M5 21h14a1 1 0 001-1V7a1 1 0 00-1-1H5a1 1 0 00-1 1v13a1 1 0 001 1z"/>
                    </svg>
                </div>

                <p class="mt-5 text-3xl font-bold text-slate-900">
                    {{ number_format($stats['kegiatan']) }}
                </p>

                <p class="mt-1 text-sm font-medium text-slate-600">
                    Kegiatan
                </p>

                <p class="mt-2 text-xs text-rose-600">
                    {{ number_format($kegiatanBerlangsung) }} berlangsung
                </p>
            </div>

        </div>
    </div>
</section>


<!-- INFORMASI -->
<section class="bg-white py-16">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">

        <div class="max-w-2xl">
            <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">
                Informasi Sistem
            </p>

            <h2 class="mt-2 text-3xl font-bold text-slate-900">
                Satu platform untuk data kemitraan dan pendidikan
            </h2>

            <p class="mt-4 leading-7 text-slate-600">
                Dashboard BGTK Kemitraan NTB menyediakan informasi
                terintegrasi yang membantu pengelolaan data keanggotaan,
                mitra, sekolah, program, dan kegiatan.
            </p>
        </div>


        <div class="mt-10 grid gap-6 md:grid-cols-3">

            <div class="rounded-2xl border border-slate-200 p-7">
                <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <span class="text-xl font-bold">01</span>
                </div>

                <h3 class="text-lg font-semibold text-slate-900">
                    Kemitraan
                </h3>

                <p class="mt-3 text-sm leading-6 text-slate-600">
                    Menampilkan informasi keanggotaan dan mitra
                    yang terhubung dengan BGTK NTB.
                </p>

                <a
                    href="{{ route('kemitraan') }}"
                    class="mt-5 inline-block text-sm font-semibold text-blue-600 hover:text-blue-500"
                >
                    Lihat data →
                </a>
            </div>


            <div class="rounded-2xl border border-slate-200 p-7">
                <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                    <span class="text-xl font-bold">02</span>
                </div>

                <h3 class="text-lg font-semibold text-slate-900">
                    Data Sekolah
                </h3>

                <p class="mt-3 text-sm leading-6 text-slate-600">
                    Menyediakan informasi sekolah dan kebutuhan
                    kepala sekolah yang telah tersedia dalam sistem.
                </p>

                <a
                    href="{{ route('sekolah') }}"
                    class="mt-5 inline-block text-sm font-semibold text-blue-600 hover:text-blue-500"
                >
                    Lihat data →
                </a>
            </div>


            <div class="rounded-2xl border border-slate-200 p-7">
                <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                    <span class="text-xl font-bold">03</span>
                </div>

                <h3 class="text-lg font-semibold text-slate-900">
                    Program & Kegiatan
                </h3>

                <p class="mt-3 text-sm leading-6 text-slate-600">
                    Informasi program dan kegiatan yang dikelola
                    dalam sistem BGTK Kemitraan.
                </p>

                <div class="mt-5 flex gap-4">
                    <a
                        href="{{ route('program') }}"
                        class="text-sm font-semibold text-blue-600 hover:text-blue-500"
                    >
                        Program →
                    </a>

                    <a
                        href="{{ route('kegiatan') }}"
                        class="text-sm font-semibold text-blue-600 hover:text-blue-500"
                    >
                        Kegiatan →
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- CTA -->
<section class="bg-slate-900 py-16">
    <div class="mx-auto max-w-7xl px-6 text-center lg:px-8">

        <h2 class="text-3xl font-bold text-white">
            Kelola data dengan lebih terintegrasi
        </h2>

        <p class="mx-auto mt-4 max-w-2xl text-slate-300">
            Akses dashboard pengelolaan untuk melihat, menambah,
            mengubah, dan mengelola data sistem.
        </p>

        <a
            href="{{ url('/admin') }}"
            class="mt-8 inline-flex rounded-lg bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-500"
        >
            Masuk ke Dashboard
        </a>

    </div>
</section>

@endsection