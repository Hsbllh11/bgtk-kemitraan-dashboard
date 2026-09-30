<?php

namespace App\Imports;

use App\Models\KebutuhanKepalaSekolah;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class KebutuhanKepalaSekolahImport implements ToCollection, WithHeadingRow
{
    public function __construct(
        protected string $kabupatenKota,
        protected int $tahun = 2026,
    ) {
    }

    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $namaSekolah = trim((string) ($row['nama_sekolah'] ?? ''));

            if ($namaSekolah === '') {
                continue;
            }

            KebutuhanKepalaSekolah::create([
                'tahun' => $this->tahun,
                'kabupaten_kota' => $this->kabupatenKota,

                'nama_sekolah' => $namaSekolah,

                'nama_kepala_sekolah' => $this->nullableString(
                    $row['nama_kepala_sekolah'] ?? null
                ),

                'lokasi_sekolah' => $this->nullableString(
                    $row['lokasi_sekolah'] ?? null
                ),

                'usia' => $this->nullableInteger(
                    $row['usia'] ?? null
                ),

                'status_ks' => $this->nullableString(
                    $row['status_ks'] ?? null
                ),

                'status_sekolah' => $this->nullableString(
                    $row['status_sekolah'] ?? null
                ),

                'tanggal_pensiun' => $this->parseDate(
                    $row['tanggal_pensiun'] ?? null
                ),

                'akhir_periode' => $this->nullableString(
                    $row['akhir_periode'] ?? null
                ),

                'periode_penugasan' => $this->nullableString(
                    $row['periode_penugasan'] ?? null
                ),

                'pemetaan' => $this->nullableString(
                    $row['pemetaan'] ?? null
                ),
            ]);
        }
    }

    private function nullableString(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }

    private function nullableInteger(mixed $value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (!is_numeric($value)) {
            return null;
        }

        return (int) $value;
    }

    private function parseDate(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        try {
            if ($value instanceof DateTimeInterface) {
                return Carbon::instance($value)->format('Y-m-d');
            }

            if (is_numeric($value)) {
                return Carbon::instance(
                    Date::excelToDateTimeObject((float) $value)
                )->format('Y-m-d');
            }

            return Carbon::parse((string) $value)->format('Y-m-d');
        } catch (\Throwable) {
            return null;
        }
    }
}