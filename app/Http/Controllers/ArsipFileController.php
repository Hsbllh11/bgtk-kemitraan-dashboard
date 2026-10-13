<?php

namespace App\Http\Controllers;

use App\Models\LaporanFile;
use App\Services\FilePreviewConverter;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ArsipFileController extends Controller
{
    public function show(LaporanFile $file)
    {
        // Hanya user yang sudah login
        abort_unless(auth()->check(), 403);

        $disk = Storage::disk('local');

        abort_unless(
            $disk->exists($file->path),
            404,
            'File tidak ditemukan.'
        );

        $headers = [
            'Content-Type' => $file->mime_type ?: 'application/octet-stream'
        ];

        // ?unduh=1 -> download, selain itu tampil inline di browser
        if (request()->boolean('unduh')) {
            return $disk->download(
                $file->path,
                $file->nama,
                $headers
            );
        }

        return $disk->response(
            $file->path,
            $file->nama,
            $headers
        );
    }

    /**
     * Preview file Office sebagai PDF
     */
    public function pdf(
        LaporanFile $file,
        FilePreviewConverter $converter
    ) {
        abort_unless(auth()->check(), 403);

        try {
            $path = $converter->pdfFor($file);
        } catch (\Throwable $e) {
            report($e);

            abort(
                500,
                'Preview tidak dapat dibuat. Silakan download file.'
            );
        }

        return Storage::disk('local')->response(
            $path,
            pathinfo($file->nama, PATHINFO_FILENAME) . '.pdf',
            [
                'Content-Type' => 'application/pdf',
            ]
        );
    }

    /**
     * Preview isi file Excel sebagai tabel HTML
     */
    public function tabel(LaporanFile $file)
    {
        abort_unless(auth()->check(), 403);

        $disk = Storage::disk('local');

        abort_unless(
            $disk->exists($file->path),
            404
        );

        $reader = IOFactory::createReaderForFile(
            $disk->path($file->path)
        );

        $reader->setReadDataOnly(true);

        $spreadsheet = $reader->load(
            $disk->path($file->path)
        );

        $maxRows = 500;
        $sheets = [];

        foreach ($spreadsheet->getWorksheetIterator() as $sheet) {
            $rows = $sheet->toArray(
                null,
                true,
                true,
                false
            );

            $sheets[] = [
                'title' => $sheet->getTitle(),
                'rows' => array_slice($rows, 0, $maxRows),
                'total' => count($rows),
                'truncated' => count($rows) > $maxRows,
            ];
        }

        return view('arsip.tabel', [
            'sheets' => $sheets,
            'nama' => $file->nama,
        ]);
    }
}