<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;

class PublicKegiatanController extends Controller
{
    public function index(Request $request)
    {
        $query = Kegiatan::query();

        if ($request->filled('kabupaten_kota')) {
            $query->where(
                'kabupaten_kota',
                $request->kabupaten_kota
            );
        }

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where(
                    'nama_kegiatan',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'jenis_kegiatan',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'penanggung_jawab',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'lokasi',
                    'like',
                    '%' . $search . '%'
                );
            });
        }

        $kegiatans = $query
            ->orderByDesc('tanggal_mulai')
            ->orderBy('nama_kegiatan')
            ->paginate(10)
            ->withQueryString();

        $kabupatenKota = Kegiatan::query()
            ->whereNotNull('kabupaten_kota')
            ->where('kabupaten_kota', '!=', '')
            ->select('kabupaten_kota')
            ->distinct()
            ->orderBy('kabupaten_kota')
            ->pluck('kabupaten_kota');

        $statuses = Kegiatan::query()
            ->whereNotNull('status')
            ->where('status', '!=', '')
            ->select('status')
            ->distinct()
            ->orderBy('status')
            ->pluck('status');

        $totalKegiatan = Kegiatan::count();

        $kegiatanBerlangsung = Kegiatan::where(
            'status',
            'Berlangsung'
        )->count();

        $kegiatanSelesai = Kegiatan::where(
            'status',
            'Selesai'
        )->count();

        return view('pages.kegiatan', compact(
            'kegiatans',
            'kabupatenKota',
            'statuses',
            'totalKegiatan',
            'kegiatanBerlangsung',
            'kegiatanSelesai'
        ));
    }
}