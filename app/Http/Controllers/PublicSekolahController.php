<?php

namespace App\Http\Controllers;

use App\Models\KebutuhanKepalaSekolah;
use Illuminate\Http\Request;

class PublicSekolahController extends Controller
{
    public function index(Request $request)
    {
        $query = KebutuhanKepalaSekolah::query();

        if ($request->filled('kabupaten_kota')) {
            $query->where(
                'kabupaten_kota',
                $request->kabupaten_kota
            );
        }

        if ($request->filled('status_ks')) {
            $query->where(
                'status_ks',
                $request->status_ks
            );
        }

        if ($request->filled('pemetaan')) {
            $query->where(
                'pemetaan',
                $request->pemetaan
            );
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where(
                    'nama_sekolah',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'nama_kepala_sekolah',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'lokasi_sekolah',
                    'like',
                    '%' . $search . '%'
                );
            });
        }

        $sekolahs = $query
            ->orderBy('kabupaten_kota')
            ->orderBy('nama_sekolah')
            ->paginate(15)
            ->withQueryString();

        $kabupatenKota = KebutuhanKepalaSekolah::query()
            ->select('kabupaten_kota')
            ->distinct()
            ->orderBy('kabupaten_kota')
            ->pluck('kabupaten_kota');

        $statusKs = KebutuhanKepalaSekolah::query()
            ->whereNotNull('status_ks')
            ->where('status_ks', '!=', '')
            ->select('status_ks')
            ->distinct()
            ->orderBy('status_ks')
            ->pluck('status_ks');

        $pemetaan = KebutuhanKepalaSekolah::query()
            ->whereNotNull('pemetaan')
            ->where('pemetaan', '!=', '')
            ->select('pemetaan')
            ->distinct()
            ->orderBy('pemetaan')
            ->pluck('pemetaan');

        $totalSekolah = KebutuhanKepalaSekolah::count();

        $totalValid = KebutuhanKepalaSekolah::where(
            'pemetaan',
            'VALID_MAPPING'
        )->count();

        $totalUnmapped = KebutuhanKepalaSekolah::where(
            'pemetaan',
            'UNMAPPED'
        )->count();

        return view('pages.sekolah', compact(
            'sekolahs',
            'kabupatenKota',
            'statusKs',
            'pemetaan',
            'totalSekolah',
            'totalValid',
            'totalUnmapped'
        ));
    }
}