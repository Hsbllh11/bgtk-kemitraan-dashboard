<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'BGTK Kemitraan NTB')</title>

    <meta
        name="description"
        content="@yield('description', 'BGTK Kemitraan Nusa Tenggara Barat')"
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-slate-800">

    {{-- NAVBAR --}}
    <header class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">

            {{-- LOGO --}}
            <a href="/" class="flex items-center gap-3">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-700 text-lg font-bold text-white shadow-sm">
                    B
                </div>

                <div>
                    <div class="text-sm font-bold tracking-wide text-slate-900">
                        BGTK NTB
                    </div>

                    <div class="text-xs text-slate-500">
                        Kemitraan
                    </div>
                </div>

            </a>

            {{-- DESKTOP NAVIGATION --}}
            <nav class="hidden items-center gap-7 lg:flex">

                <a
                    href="/"
                    class="text-sm font-medium transition hover:text-blue-700 {{ request()->is('/') ? 'text-blue-700' : 'text-slate-600' }}"
                >
                    Beranda
                </a>

                <a
                    href="/profil"
                    class="text-sm font-medium transition hover:text-blue-700 {{ request()->is('profil') ? 'text-blue-700' : 'text-slate-600' }}"
                >
                    Profil
                </a>

                <a
                    href="/kemitraan"
                    class="text-sm font-medium transition hover:text-blue-700 {{ request()->is('kemitraan') ? 'text-blue-700' : 'text-slate-600' }}"
                >
                    Kemitraan
                </a>

                <a
                    href="/sekolah"
                    class="text-sm font-medium transition hover:text-blue-700 {{ request()->is('sekolah') ? 'text-blue-700' : 'text-slate-600' }}"
                >
                    Data Sekolah
                </a>

                <a
                    href="/program"
                    class="text-sm font-medium transition hover:text-blue-700 {{ request()->is('program') ? 'text-blue-700' : 'text-slate-600' }}"
                >
                    Program
                </a>

                <a
                    href="/kegiatan"
                    class="text-sm font-medium transition hover:text-blue-700 {{ request()->is('kegiatan') ? 'text-blue-700' : 'text-slate-600' }}"
                >
                    Kegiatan
                </a>

            </nav>

            {{-- DASHBOARD --}}
            <a
                href="/admin"
                class="hidden rounded-xl bg-blue-700 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-800 lg:block"
            >
                Dashboard
            </a>

            {{-- MOBILE MENU BUTTON --}}
            <button
                type="button"
                class="rounded-lg border border-slate-200 px-3 py-2 text-slate-600 lg:hidden"
                onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
            >
                ☰
            </button>

        </div>

        {{-- MOBILE NAVIGATION --}}
        <div
            id="mobile-menu"
            class="hidden border-t border-slate-200 bg-white px-6 py-4 lg:hidden"
        >

            <div class="flex flex-col gap-2">

                <a href="/" class="rounded-lg px-3 py-2 text-sm font-medium hover:bg-slate-50">
                    Beranda
                </a>

                <a href="/profil" class="rounded-lg px-3 py-2 text-sm font-medium hover:bg-slate-50">
                    Profil
                </a>

                <a href="/kemitraan" class="rounded-lg px-3 py-2 text-sm font-medium hover:bg-slate-50">
                    Kemitraan
                </a>

                <a href="/sekolah" class="rounded-lg px-3 py-2 text-sm font-medium hover:bg-slate-50">
                    Data Sekolah
                </a>

                <a href="/program" class="rounded-lg px-3 py-2 text-sm font-medium hover:bg-slate-50">
                    Program
                </a>

                <a href="/kegiatan" class="rounded-lg px-3 py-2 text-sm font-medium hover:bg-slate-50">
                    Kegiatan
                </a>

                <a
                    href="/admin"
                    class="mt-2 rounded-xl bg-blue-700 px-5 py-3 text-center text-sm font-semibold text-white"
                >
                    Dashboard
                </a>

            </div>

        </div>

    </header>


    {{-- CONTENT --}}
    <main>
        @yield('content')
    </main>


    {{-- FOOTER --}}
    <footer class="mt-20 bg-slate-950 text-white">

        <div class="mx-auto max-w-7xl px-6 py-12">

            <div class="grid gap-10 md:grid-cols-3">

                <div>
                    <h3 class="text-lg font-bold">
                        BGTK Nusa Tenggara Barat
                    </h3>

                    <p class="mt-3 max-w-md text-sm leading-6 text-slate-400">
                        Platform informasi dan pengelolaan data kemitraan
                        BGTK Nusa Tenggara Barat.
                    </p>
                </div>

                <div>
                    <h3 class="font-semibold">
                        Navigasi
                    </h3>

                    <div class="mt-4 flex flex-col gap-2 text-sm text-slate-400">
                        <a href="/" class="hover:text-white">Beranda</a>
                        <a href="/profil" class="hover:text-white">Profil</a>
                        <a href="/kemitraan" class="hover:text-white">Kemitraan</a>
                        <a href="/sekolah" class="hover:text-white">Data Sekolah</a>
                        <a href="/program" class="hover:text-white">Program</a>
                        <a href="/kegiatan" class="hover:text-white">Kegiatan</a>
                    </div>
                </div>

                <div>
                    <h3 class="font-semibold">
                        Sistem
                    </h3>

                    <div class="mt-4 flex flex-col gap-2 text-sm text-slate-400">
                        <a href="/admin" class="hover:text-white">
                            Dashboard
                        </a>

                        <span>
                            Nusa Tenggara Barat
                        </span>
                    </div>
                </div>

            </div>

            <div class="mt-10 border-t border-slate-800 pt-6 text-sm text-slate-500">
                © {{ date('Y') }} BGTK Nusa Tenggara Barat.
                Seluruh hak cipta dilindungi.
            </div>

        </div>

    </footer>

</body>
</html>