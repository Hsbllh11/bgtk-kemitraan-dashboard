<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    protected $fillable = [
        'nama_mitra',
        'jenis_mitra',
        'instansi',
        'kabupaten_kota',
        'alamat',
        'kontak',
        'email',
        'status',
        'tanggal_bergabung',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_bergabung' => 'date',
    ];
}