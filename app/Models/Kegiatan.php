<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $fillable = [
        'nama_kegiatan',
        'jenis_kegiatan',
        'kabupaten_kota',
        'lokasi',
        'tanggal_mulai',
        'tanggal_selesai',
        'penanggung_jawab',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];
}