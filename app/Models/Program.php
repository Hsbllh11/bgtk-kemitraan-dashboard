<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'nama_program',
        'jenis_program',
        'deskripsi',
        'kabupaten_kota',
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