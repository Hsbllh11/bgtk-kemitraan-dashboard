<x-filament-panels::page>

    <div class="space-y-6">

        <x-filament::section>
            <x-slot name="heading">
                Import Data Kebutuhan Kepala Sekolah
            </x-slot>

            <x-slot name="description">
                Upload data kebutuhan kepala sekolah dari file Excel atau CSV
                berdasarkan kabupaten/kota di Nusa Tenggara Barat.
            </x-slot>

            <form wire:submit="import" class="space-y-6">

                {{ $this->form }}

                <div class="flex justify-end">
                    <x-filament::button type="submit" icon="heroicon-m-arrow-up-tray">
                        Import Data
                    </x-filament::button>
                </div>

            </form>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">
                Format File
            </x-slot>

            <div class="space-y-3 text-sm text-gray-600 dark:text-gray-300">

                <p>
                    File Excel/CSV harus memiliki kolom berikut:
                </p>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="border-b">
                                <th class="px-3 py-2">No</th>
                                <th class="px-3 py-2">Nama Kolom</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr class="border-b">
                                <td class="px-3 py-2">1</td>
                                <td class="px-3 py-2">Nama Sekolah</td>
                            </tr>
                            <tr class="border-b">
                                <td class="px-3 py-2">2</td>
                                <td class="px-3 py-2">Nama Kepala Sekolah</td>
                            </tr>
                            <tr class="border-b">
                                <td class="px-3 py-2">3</td>
                                <td class="px-3 py-2">Lokasi Sekolah</td>
                            </tr>
                            <tr class="border-b">
                                <td class="px-3 py-2">4</td>
                                <td class="px-3 py-2">Usia</td>
                            </tr>
                            <tr class="border-b">
                                <td class="px-3 py-2">5</td>
                                <td class="px-3 py-2">Status KS</td>
                            </tr>
                            <tr class="border-b">
                                <td class="px-3 py-2">6</td>
                                <td class="px-3 py-2">Status Sekolah</td>
                            </tr>
                            <tr class="border-b">
                                <td class="px-3 py-2">7</td>
                                <td class="px-3 py-2">Tanggal Pensiun</td>
                            </tr>
                            <tr class="border-b">
                                <td class="px-3 py-2">8</td>
                                <td class="px-3 py-2">Akhir Periode</td>
                            </tr>
                            <tr class="border-b">
                                <td class="px-3 py-2">9</td>
                                <td class="px-3 py-2">Periode Penugasan</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2">10</td>
                                <td class="px-3 py-2">Pemetaan</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <p class="pt-2">
                    <strong>Catatan:</strong>
                    Pilih kabupaten/kota sesuai dengan file yang sedang diunggah.
                    Kolom yang kosong pada file sumber akan tetap disimpan sebagai
                    data kosong.
                </p>

            </div>
        </x-filament::section>

    </div>

</x-filament-panels::page>