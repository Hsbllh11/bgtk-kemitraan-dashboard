<?php

namespace App\Http\Controllers;

use App\Models\Keanggotaan;
use App\Models\Mitra;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PublicKemitraanController extends Controller
{
    public function index(Request $request): View
    {
        $kabupatenKota = $request->string('kabupaten_kota')->trim()->toString();
        $status = $request->string('status')->trim()->toString();
        $search = $request->string('search')->trim()->toString();

        $keanggotaans = Keanggotaan::query()
            ->when($kabupatenKota !== '', function ($query) use ($kabupatenKota) {
                $query->where('kabupaten_kota', $kabupatenKota);
            })
            ->when($status !== '', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('instansi', 'like', '%' . $search . '%')
                        ->orWhere('jabatan', 'like', '%' . $search . '%')
                        ->orWhere('jenis_mitra', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        $mitras = Mitra::query()
            ->when($kabupatenKota !== '', function ($query) use ($kabupatenKota) {
                $query->where('kabupaten_kota', $kabupatenKota);
            })
            ->when($status !== '', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('nama_mitra', 'like', '%' . $search . '%')
                        ->orWhere('instansi', 'like', '%' . $search . '%')
                        ->orWhere('jenis_mitra', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('nama_mitra')
            ->paginate(10, ['*'], 'mitra_page')
            ->withQueryString();

        $kabupatenKotas = Keanggotaan::query()
            ->whereNotNull('kabupaten_kota')
            ->where('kabupaten_kota', '!=', '')
            ->distinct()
            ->orderBy('kabupaten_kota')
            ->pluck('kabupaten_kota');

        $statuses = Keanggotaan::query()
            ->whereNotNull('status')
            ->where('status', '!=', '')
            ->distinct()
            ->orderBy('status')
            ->pluck('status');

        $totalKeanggotaan = Keanggotaan::count();

        $totalKeanggotaanAktif = Keanggotaan::where(
            'status',
            'Aktif'
        )->count();

        $totalMitra = Mitra::count();

        $totalMitraAktif = Mitra::where(
            'status',
            'Aktif'
        )->count();

        return view('pages.kemitraan', [
            'keanggotaans' => $keanggotaans,
            'mitras' => $mitras,
            'kabupatenKotas' => $kabupatenKotas,
            'statuses' => $statuses,
            'totalKeanggotaan' => $totalKeanggotaan,
            'totalKeanggotaanAktif' => $totalKeanggotaanAktif,
            'totalMitra' => $totalMitra,
            'totalMitraAktif' => $totalMitraAktif,
            'search' => $search,
            'selectedKabupatenKota' => $kabupatenKota,
            'selectedStatus' => $status,
        ]);
    }
}