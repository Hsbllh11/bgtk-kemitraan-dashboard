<?php

namespace App\Imports;

use App\Models\Mitra;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class MitraImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $namaMitra = trim((string) ($row['nama_mitra'] ?? ''));

            if ($namaMitra === '') {
                continue;
            }

            Mitra::create([
                'nama_mitra' => $namaMitra,
                'jenis_mitra' => $this->nullableString(
                    $row['jenis_mitra'] ?? null
                ) ?? '',
                'instansi' => $this->nullableString(
                    $row['instansi'] ?? null
                ),
                'kabupaten_kota' => $this->nullableString(
                    $row['kabupaten_kota'] ?? null
                ) ?? '',
                'alamat' => $this->nullableString(
                    $row['alamat'] ?? null
                ),
                'kontak' => $this->nullableString(
                    $row['kontak'] ?? null
                ),
                'email' => $this->nullableString(
                    $row['email'] ?? null
                ),
                'status' => $this->nullableString(
                    $row['status'] ?? null
                ) ?? 'Aktif',
                'tanggal_bergabung' => $this->parseDate(
                    $row['tanggal_bergabung'] ?? null
                ),
                'keterangan' => $this->nullableString(
                    $row['keterangan'] ?? null
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