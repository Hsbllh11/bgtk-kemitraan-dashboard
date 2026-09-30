<?php

namespace App\Filament\Pages;

use App\Models\Keanggotaan;
use App\Models\Kegiatan;
use App\Models\Mitra;
use App\Models\Program;
use BackedEnum;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Laporan extends Page
{
    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedDocumentChartBar;

    protected static string|\UnitEnum|null $navigationGroup =
        'LAINNYA';

    protected static ?string $navigationLabel =
        'Laporan';

    protected static ?string $title =
        'Laporan';

    protected string $view =
        'filament.pages.laporan';

    public ?string $kabupatenKota = null;

    public ?string $status = null;


    /*
    |--------------------------------------------------------------------------
    | FILTER KABUPATEN / KOTA
    |--------------------------------------------------------------------------
    */

    public function getKabupatenKotaOptions(): array
    {
        return Keanggotaan::query()
            ->whereNotNull('kabupaten_kota')
            ->distinct()
            ->orderBy('kabupaten_kota')
            ->pluck('kabupaten_kota', 'kabupaten_kota')
            ->toArray();
    }


    /*
    |--------------------------------------------------------------------------
    | FILTER STATUS
    |--------------------------------------------------------------------------
    */

    public function getStatusOptions(): array
    {
        return [
            'Aktif' => 'Aktif',
            'Nonaktif' => 'Nonaktif',
            'Direncanakan' => 'Direncanakan',
            'Berlangsung' => 'Berlangsung',
            'Selesai' => 'Selesai',
            'Dibatalkan' => 'Dibatalkan',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | RESET FILTER
    |--------------------------------------------------------------------------
    */

    public function resetFilter(): void
    {
        $this->kabupatenKota = null;

        $this->status = null;
    }


    /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL / CSV
    |--------------------------------------------------------------------------
    */

    public function exportExcel(): StreamedResponse
    {
        $filename = 'laporan-bgtk-kemitraan-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () {

            $handle = fopen('php://output', 'w');

            /*
            |--------------------------------------------------------------------------
            | BOM UTF-8
            |--------------------------------------------------------------------------
            */

            fwrite($handle, "\xEF\xBB\xBF");


            /*
            |--------------------------------------------------------------------------
            | JUDUL
            |--------------------------------------------------------------------------
            */

            fputcsv($handle, [
                'BGTK KEMITRAAN DASHBOARD',
            ], ';');

            fputcsv($handle, [
                'Laporan Data Kemitraan',
            ], ';');

            fputcsv($handle, [
                'Tanggal Export',
                now()->format('d-m-Y H:i:s'),
            ], ';');

            fputcsv($handle, [
                'Kabupaten / Kota',
                $this->kabupatenKota ?: 'Semua',
            ], ';');

            fputcsv($handle, [
                'Status',
                $this->status ?: 'Semua',
            ], ';');

            fputcsv($handle, [], ';');


            /*
            |--------------------------------------------------------------------------
            | KEANGGOTAAN
            |--------------------------------------------------------------------------
            */

            fputcsv($handle, [
                'REKAP DATA KEANGGOTAAN',
            ], ';');

            fputcsv($handle, [
                'No',
                'Nama',
                'NIP / NIK',
                'Instansi',
                'Kabupaten / Kota',
                'Jabatan',
                'Jenis Mitra',
                'Peran',
                'Status',
                'Tanggal Bergabung',
            ], ';');

            $keanggotaans = Keanggotaan::query()
                ->when($this->kabupatenKota, function ($query) {
                    $query->where(
                        'kabupaten_kota',
                        $this->kabupatenKota
                    );
                })
                ->when($this->status, function ($query) {
                    $query->where(
                        'status',
                        $this->status
                    );
                })
                ->orderBy('nama')
                ->get();

            foreach ($keanggotaans as $index => $keanggotaan) {

                fputcsv($handle, [
                    $index + 1,
                    $keanggotaan->nama,
                    $keanggotaan->nip_nik,
                    $keanggotaan->instansi,
                    $keanggotaan->kabupaten_kota,
                    $keanggotaan->jabatan,
                    $keanggotaan->jenis_mitra,
                    $keanggotaan->peran,
                    $keanggotaan->status,
                    $keanggotaan->tanggal_bergabung?->format('d-m-Y'),
                ], ';');
            }


            fputcsv($handle, [] , ';');


            /*
            |--------------------------------------------------------------------------
            | MITRA
            |--------------------------------------------------------------------------
            */

            fputcsv($handle, [
                'REKAP DATA MITRA',
            ], ';');

            fputcsv($handle, [
                'No',
                'Nama Mitra',
                'Jenis Mitra',
                'Instansi',
                'Kabupaten / Kota',
                'Alamat',
                'Kontak',
                'Email',
                'Status',
                'Tanggal Bergabung',
                'Keterangan',
            ], ';');

            $mitras = Mitra::query()
                ->when($this->kabupatenKota, function ($query) {
                    $query->where(
                        'kabupaten_kota',
                        $this->kabupatenKota
                    );
                })
                ->when($this->status, function ($query) {
                    $query->where(
                        'status',
                        $this->status
                    );
                })
                ->orderBy('nama_mitra')
                ->get();

            foreach ($mitras as $index => $mitra) {

                fputcsv($handle, [
                    $index + 1,
                    $mitra->nama_mitra,
                    $mitra->jenis_mitra,
                    $mitra->instansi,
                    $mitra->kabupaten_kota,
                    $mitra->alamat,
                    $mitra->kontak,
                    $mitra->email,
                    $mitra->status,
                    $mitra->tanggal_bergabung?->format('d-m-Y'),
                    $mitra->keterangan,
                ], ';');
            }


            fputcsv($handle, [], ';');


            /*
            |--------------------------------------------------------------------------
            | KEGIATAN
            |--------------------------------------------------------------------------
            */

            fputcsv($handle, [
                'REKAP DATA KEGIATAN',
            ], ';');

            fputcsv($handle, [
                'No',
                'Nama Kegiatan',
                'Jenis Kegiatan',
                'Kabupaten / Kota',
                'Lokasi',
                'Tanggal Mulai',
                'Tanggal Selesai',
                'Penanggung Jawab',
                'Status',
                'Keterangan',
            ], ';');

            $kegiatans = Kegiatan::query()
                ->when($this->kabupatenKota, function ($query) {
                    $query->where(
                        'kabupaten_kota',
                        $this->kabupatenKota
                    );
                })
                ->when($this->status, function ($query) {
                    $query->where(
                        'status',
                        $this->status
                    );
                })
                ->orderBy('tanggal_mulai', 'desc')
                ->get();

            foreach ($kegiatans as $index => $kegiatan) {

                fputcsv($handle, [
                    $index + 1,
                    $kegiatan->nama_kegiatan,
                    $kegiatan->jenis_kegiatan,
                    $kegiatan->kabupaten_kota,
                    $kegiatan->lokasi,
                    $kegiatan->tanggal_mulai?->format('d-m-Y'),
                    $kegiatan->tanggal_selesai?->format('d-m-Y'),
                    $kegiatan->penanggung_jawab,
                    $kegiatan->status,
                    $kegiatan->keterangan,
                ], ';');
            }


            fputcsv($handle, [], ';');


            /*
            |--------------------------------------------------------------------------
            | PROGRAM
            |--------------------------------------------------------------------------
            */

            fputcsv($handle, [
                'REKAP DATA PROGRAM',
            ], ';');

            fputcsv($handle, [
                'No',
                'Nama Program',
                'Jenis Program',
                'Kabupaten / Kota',
                'Tanggal Mulai',
                'Tanggal Selesai',
                'Penanggung Jawab',
                'Status',
                'Keterangan',
            ], ';');

            $programs = Program::query()
                ->when($this->kabupatenKota, function ($query) {
                    $query->where(
                        'kabupaten_kota',
                        $this->kabupatenKota
                    );
                })
                ->when($this->status, function ($query) {
                    $query->where(
                        'status',
                        $this->status
                    );
                })
                ->orderBy('tanggal_mulai', 'desc')
                ->get();

            foreach ($programs as $index => $program) {

                fputcsv($handle, [
                    $index + 1,
                    $program->nama_program,
                    $program->jenis_program,
                    $program->kabupaten_kota,
                    $program->tanggal_mulai?->format('d-m-Y'),
                    $program->tanggal_selesai?->format('d-m-Y'),
                    $program->penanggung_jawab,
                    $program->status,
                    $program->keterangan,
                ], ';');
            }

            fclose($handle);

        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | EXPORT PDF
    |--------------------------------------------------------------------------
    */

    public function exportPdf()
    {
        $data = [
            'kabupatenKota' => $this->kabupatenKota,
            'status' => $this->status,

            'keanggotaans' => Keanggotaan::query()
                ->when($this->kabupatenKota, function ($query) {
                    $query->where(
                        'kabupaten_kota',
                        $this->kabupatenKota
                    );
                })
                ->when($this->status, function ($query) {
                    $query->where(
                        'status',
                        $this->status
                    );
                })
                ->orderBy('nama')
                ->get(),

            'mitras' => Mitra::query()
                ->when($this->kabupatenKota, function ($query) {
                    $query->where(
                        'kabupaten_kota',
                        $this->kabupatenKota
                    );
                })
                ->when($this->status, function ($query) {
                    $query->where(
                        'status',
                        $this->status
                    );
                })
                ->orderBy('nama_mitra')
                ->get(),

            'kegiatans' => Kegiatan::query()
                ->when($this->kabupatenKota, function ($query) {
                    $query->where(
                        'kabupaten_kota',
                        $this->kabupatenKota
                    );
                })
                ->when($this->status, function ($query) {
                    $query->where(
                        'status',
                        $this->status
                    );
                })
                ->orderBy('tanggal_mulai', 'desc')
                ->get(),

            'programs' => Program::query()
                ->when($this->kabupatenKota, function ($query) {
                    $query->where(
                        'kabupaten_kota',
                        $this->kabupatenKota
                    );
                })
                ->when($this->status, function ($query) {
                    $query->where(
                        'status',
                        $this->status
                    );
                })
                ->orderBy('tanggal_mulai', 'desc')
                ->get(),
        ];

        $pdf = Pdf::loadView(
            'filament.pages.laporan-pdf',
            $data
        );

        $pdf->setPaper('A4', 'landscape');

        return response()->streamDownload(
            function () use ($pdf) {
                echo $pdf->output();
            },
            'laporan-bgtk-kemitraan-' . now()->format('Y-m-d-His') . '.pdf'
        );
    }
}