<?php

namespace App\Http\Controllers;

use App\Models\LaporanFile;
use Illuminate\Support\Facades\Storage;

class ArsipFileController extends Controller
{
    public function show(LaporanFile $file)
    {
        // Hanya user yang sudah login
        abort_unless(auth()->check(), 403);

        $disk = Storage::disk('local');

        abort_unless($disk->exists($file->path), 404, 'File tidak ditemukan.');

        $headers = ['Content-Type' => $file->mime_type ?: 'application/octet-stream'];

        // ?unduh=1 -> download, selain itu tampil inline di browser
        if (request()->boolean('unduh')) {
            return $disk->download($file->path, $file->nama, $headers);
        }

        return $disk->response($file->path, $file->nama, $headers);
    }
}