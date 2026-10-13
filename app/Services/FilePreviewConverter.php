<?php

namespace App\Services;

use App\Models\LaporanFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class FilePreviewConverter
{
    /** Mengembalikan path PDF hasil konversi (di disk local), memakai cache. */
    public function pdfFor(LaporanFile $file): string
    {
        $disk   = Storage::disk('local');
        $target = 'arsip-preview/' . $file->id . '.pdf';

        if ($disk->exists($target)) {
            return $target;
        }

        $ext    = strtolower(pathinfo($file->nama, PATHINFO_EXTENSION));
        $tmpDir = storage_path('app/private/arsip-preview-tmp/' . Str::uuid());
        File::ensureDirectoryExists($tmpDir);

        // Salin ke nama sederhana agar aman dari karakter khusus
        $source = $tmpDir . DIRECTORY_SEPARATOR . 'source.' . $ext;
        File::copy($disk->path($file->path), $source);

        $profile = 'file:///' . str_replace('\\', '/', $tmpDir) . '/profile';

        $result = Process::timeout(120)->run([
            config('services.libreoffice.path'),
            '--headless',
            '-env:UserInstallation=' . $profile,
            '--convert-to', 'pdf',
            '--outdir', $tmpDir,
            $source,
        ]);

        $pdf = $tmpDir . DIRECTORY_SEPARATOR . 'source.pdf';

        if (! $result->successful() || ! File::exists($pdf)) {
            File::deleteDirectory($tmpDir);
            throw new RuntimeException('Konversi gagal: ' . $result->errorOutput());
        }

        $disk->put($target, File::get($pdf));
        File::deleteDirectory($tmpDir);

        return $target;
    }
}