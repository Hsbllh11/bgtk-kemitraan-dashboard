<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Keanggotaan;
use App\Models\KebutuhanKepalaSekolah;
use App\Models\Mitra;
use App\Models\Program;

class PublicHomeController extends Controller
{
    public function index()
    {
        $stats = [
            'keanggotaan' => Keanggotaan::count(),
            'mitra' => Mitra::count(),
            'sekolah' => KebutuhanKepalaSekolah::count(),
            'program' => Program::count(),
            'kegiatan' => Kegiatan::count(),
        ];

        $keanggotaanAktif = Keanggotaan::where('status', 'Aktif')->count();

        $mitraAktif = Mitra::where('status', 'Aktif')->count();

        $sekolahValid = KebutuhanKepalaSekolah::where(
            'pemetaan',
            'VALID_MAPPING'
        )->count();

        $sekolahUnmapped = KebutuhanKepalaSekolah::where(
            'pemetaan',
            'UNMAPPED'
        )->count();

        $programBerlangsung = Program::where(
            'status',
            'Berlangsung'
        )->count();

        $kegiatanBerlangsung = Kegiatan::where(
            'status',
            'Berlangsung'
        )->count();

        return view('pages.home', compact(
            'stats',
            'keanggotaanAktif',
            'mitraAktif',
            'sekolahValid',
            'sekolahUnmapped',
            'programBerlangsung',
            'kegiatanBerlangsung'
        ));
    }
}