<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class keanggotaan extends Model
{
    protected $fillable = [
        'nama',
        'nip_nik',
        'instansi',
        'kabupaten_kota',
        'jabatan',
        'jenis_mitra',
        'peran',
        'status',
        'tanggal_bergabung',
    ];

    protected $casts = [
        'tanggal_bergabung' => 'date',
    ];
}