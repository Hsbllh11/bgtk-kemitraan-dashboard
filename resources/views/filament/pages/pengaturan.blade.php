<x-filament-panels::page>

    {{-- ========================================================= --}}
    {{-- INFORMASI SISTEM --}}
    {{-- ========================================================= --}}

    <x-filament::section>

        <x-slot name="heading">
            Informasi Sistem
        </x-slot>

        <x-slot name="description">
            Informasi umum mengenai aplikasi BGTK Kemitraan Dashboard.
        </x-slot>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

            {{-- Nama Aplikasi --}}
            <div>
                <div class="text-sm font-medium text-gray-500">
                    Nama Aplikasi
                </div>

                <div class="mt-1 text-base font-semibold">
                    BGTK Kemitraan Dashboard
                </div>
            </div>


            {{-- Instansi --}}
            <div>
                <div class="text-sm font-medium text-gray-500">
                    Instansi
                </div>

                <div class="mt-1 text-base font-semibold">
                    BGTK Nusa Tenggara Barat
                </div>
            </div>


            {{-- Wilayah --}}
            <div>
                <div class="text-sm font-medium text-gray-500">
                    Wilayah Kerja
                </div>

                <div class="mt-1 text-base font-semibold">
                    Nusa Tenggara Barat
                </div>
            </div>


            {{-- Versi --}}
            <div>
                <div class="text-sm font-medium text-gray-500">
                    Versi Aplikasi
                </div>

                <div class="mt-1 text-base font-semibold">
                    1.0.0
                </div>
            </div>

        </div>

    </x-filament::section>


    {{-- ========================================================= --}}
    {{-- DESKRIPSI SISTEM --}}
    {{-- ========================================================= --}}

    <div class="mt-6">

        <x-filament::section>

            <x-slot name="heading">
                Deskripsi Sistem
            </x-slot>

            <div class="space-y-4 text-sm leading-6 text-gray-600">

                <p>
                    BGTK Kemitraan Dashboard merupakan aplikasi berbasis
                    web yang digunakan untuk membantu pengelolaan,
                    pemantauan, dan penyajian data kemitraan secara
                    terintegrasi.
                </p>

                <p>
                    Sistem ini menyediakan pengelolaan data keanggotaan,
                    data mitra, data kegiatan, data program, serta laporan
                    yang dapat digunakan sebagai informasi pendukung dalam
                    pengelolaan kemitraan.
                </p>

            </div>

        </x-filament::section>

    </div>


    {{-- ========================================================= --}}
    {{-- INFORMASI DATA --}}
    {{-- ========================================================= --}}

    <div class="mt-6">

        <x-filament::section>

            <x-slot name="heading">
                Informasi Data
            </x-slot>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">

                {{-- Keanggotaan --}}
                <div class="rounded-xl border p-5">

                    <div class="text-sm text-gray-500">
                        Data Keanggotaan
                    </div>

                    <div class="mt-2 text-2xl font-bold">
                        {{ \App\Models\Keanggotaan::count() }}
                    </div>

                    <div class="mt-1 text-xs text-gray-500">
                        Data tersimpan
                    </div>

                </div>


                {{-- Mitra --}}
                <div class="rounded-xl border p-5">

                    <div class="text-sm text-gray-500">
                        Data Mitra
                    </div>

                    <div class="mt-2 text-2xl font-bold">
                        {{ \App\Models\Mitra::count() }}
                    </div>

                    <div class="mt-1 text-xs text-gray-500">
                        Data tersimpan
                    </div>

                </div>


                {{-- Kegiatan --}}
                <div class="rounded-xl border p-5">

                    <div class="text-sm text-gray-500">
                        Data Kegiatan
                    </div>

                    <div class="mt-2 text-2xl font-bold">
                        {{ \App\Models\Kegiatan::count() }}
                    </div>

                    <div class="mt-1 text-xs text-gray-500">
                        Data tersimpan
                    </div>

                </div>


                {{-- Program --}}
                <div class="rounded-xl border p-5">

                    <div class="text-sm text-gray-500">
                        Data Program
                    </div>

                    <div class="mt-2 text-2xl font-bold">
                        {{ \App\Models\Program::count() }}
                    </div>

                    <div class="mt-1 text-xs text-gray-500">
                        Data tersimpan
                    </div>

                </div>

            </div>

        </x-filament::section>

    </div>


    {{-- ========================================================= --}}
    {{-- TEKNOLOGI SISTEM --}}
    {{-- ========================================================= --}}

    <div class="mt-6">

        <x-filament::section>

            <x-slot name="heading">
                Teknologi Sistem
            </x-slot>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                <div class="rounded-lg border p-4">
                    <div class="text-sm text-gray-500">
                        Framework
                    </div>

                    <div class="mt-1 font-semibold">
                        Laravel
                    </div>
                </div>


                <div class="rounded-lg border p-4">
                    <div class="text-sm text-gray-500">
                        Admin Panel
                    </div>

                    <div class="mt-1 font-semibold">
                        Filament
                    </div>
                </div>


                <div class="rounded-lg border p-4">
                    <div class="text-sm text-gray-500">
                        Database
                    </div>

                    <div class="mt-1 font-semibold">
                        SQLite
                    </div>
                </div>


                <div class="rounded-lg border p-4">
                    <div class="text-sm text-gray-500">
                        Server Lokal
                    </div>

                    <div class="mt-1 font-semibold">
                        XAMPP
                    </div>
                </div>

            </div>

        </x-filament::section>

    </div>


    {{-- ========================================================= --}}
    {{-- INFORMASI PENGEMBANGAN --}}
    {{-- ========================================================= --}}

    <div class="mt-6">

        <x-filament::section>

            <x-slot name="heading">
                Informasi Pengembangan
            </x-slot>

            <div class="rounded-lg bg-gray-50 p-5">

                <div class="text-sm leading-6 text-gray-600">

                    Sistem dikembangkan untuk mendukung pengelolaan
                    informasi kemitraan BGTK Nusa Tenggara Barat agar
                    data dapat dikelola secara terstruktur dan disajikan
                    dalam bentuk dashboard yang mudah dipantau.

                </div>

            </div>

        </x-filament::section>

    </div>

</x-filament-panels::page>