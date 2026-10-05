<?php

namespace App\Imports;

use App\Models\Keanggotaan;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class KeanggotaanImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $nama = trim((string) ($row['nama'] ?? ''));

            if ($nama === '') {
                continue;
            }

            Keanggotaan::create([
                'nama' => $nama,
                'nip_nik' => $this->nullableString(
                    $row['nip_nik'] ?? null
                ),
                'instansi' => $this->nullableString(
                    $row['instansi'] ?? null
                ) ?? '',
                'kabupaten_kota' => $this->nullableString(
                    $row['kabupaten_kota'] ?? null
                ) ?? '',
                'jabatan' => $this->nullableString(
                    $row['jabatan'] ?? null
                ),
                'jenis_mitra' => $this->nullableString(
                    $row['jenis_mitra'] ?? null
                ) ?? '',
                'peran' => $this->nullableString(
                    $row['peran'] ?? null
                ) ?? '',
                'status' => $this->nullableString(
                    $row['status'] ?? null
                ) ?? 'Aktif',
                'tanggal_bergabung' => $this->parseDate(
                    $row['tanggal_bergabung'] ?? null
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