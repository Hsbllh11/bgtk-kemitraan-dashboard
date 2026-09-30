<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KebutuhanKepalaSekolah extends Model
{
    protected $table = 'kebutuhan_kepala_sekolahs';

    protected $fillable = [
        'tahun',
        'kabupaten_kota',
        'nama_sekolah',
        'nama_kepala_sekolah',
        'lokasi_sekolah',
        'usia',
        'status_ks',
        'status_sekolah',
        'tanggal_pensiun',
        'akhir_periode',
        'periode_penugasan',
        'pemetaan',
    ];

    protected function casts(): array
    {
        return [
            'tahun' => 'integer',
            'usia' => 'integer',
            'tanggal_pensiun' => 'date',
        ];
    }
}