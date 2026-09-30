<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class PublicProgramController extends Controller
{
    public function index(Request $request)
    {
        $query = Program::query();

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
                    'nama_program',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'jenis_program',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'penanggung_jawab',
                    'like',
                    '%' . $search . '%'
                );
            });
        }

        $programs = $query
            ->orderByDesc('tanggal_mulai')
            ->orderBy('nama_program')
            ->paginate(10)
            ->withQueryString();

        $kabupatenKota = Program::query()
            ->whereNotNull('kabupaten_kota')
            ->where('kabupaten_kota', '!=', '')
            ->select('kabupaten_kota')
            ->distinct()
            ->orderBy('kabupaten_kota')
            ->pluck('kabupaten_kota');

        $statuses = Program::query()
            ->whereNotNull('status')
            ->where('status', '!=', '')
            ->select('status')
            ->distinct()
            ->orderBy('status')
            ->pluck('status');

        $totalProgram = Program::count();

        $programBerlangsung = Program::where(
            'status',
            'Berlangsung'
        )->count();

        $programSelesai = Program::where(
            'status',
            'Selesai'
        )->count();

        return view('pages.program', compact(
            'programs',
            'kabupatenKota',
            'statuses',
            'totalProgram',
            'programBerlangsung',
            'programSelesai'
        ));
    }
}