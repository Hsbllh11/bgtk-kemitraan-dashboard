<?php

namespace App\Imports;

use App\Models\Program;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ProgramImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $namaProgram = trim((string) ($row['nama_program'] ?? ''));

            if ($namaProgram === '') {
                continue;
            }

            Program::create([
                'nama_program' => $namaProgram,
                'jenis_program' => $this->nullableString(
                    $row['jenis_program'] ?? null
                ) ?? '',
                'deskripsi' => $this->nullableString(
                    $row['deskripsi'] ?? null
                ),
                'kabupaten_kota' => $this->nullableString(
                    $row['kabupaten_kota'] ?? null
                ),
                'tanggal_mulai' => $this->parseDate(
                    $row['tanggal_mulai'] ?? null
                ),
                'tanggal_selesai' => $this->parseDate(
                    $row['tanggal_selesai'] ?? null
                ),
                'penanggung_jawab' => $this->nullableString(
                    $row['penanggung_jawab'] ?? null
                ),
                'status' => $this->nullableString(
                    $row['status'] ?? null
                ) ?? 'Direncanakan',
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