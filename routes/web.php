<?php

use App\Http\Controllers\ArsipFileController;
use App\Http\Controllers\PublicHomeController;
use App\Http\Controllers\PublicKegiatanController;
use App\Http\Controllers\PublicKemitraanController;
use App\Http\Controllers\PublicProgramController;
use App\Http\Controllers\PublicSekolahController;
use App\Http\Controllers\PublicTendikController;
use Illuminate\Support\Facades\Route;

Route::get('/_ini', fn () => [
    'upload_max_filesize' => ini_get('upload_max_filesize'),
    'post_max_size' => ini_get('post_max_size'),
    'sapi' => php_sapi_name(),
    'ini' => php_ini_loaded_file(),
]);

Route::get('/bahasa/{locale}', function (string $locale) {
    abort_unless(in_array($locale, \App\Http\Middleware\SetLocale::BAHASA, true), 404);

    session(['locale' => $locale]);

    return redirect()->back(fallback: '/');
})->name('bahasa');

Route::get('/arsip-laporan/file/{file}', [ArsipFileController::class, 'show'])
    ->name('arsip.file');

Route::get('/', [PublicHomeController::class, 'index'])
    ->name('home');

Route::view('/profil', 'pages.profil')
    ->name('profil');

Route::get('/kemitraan', [PublicKemitraanController::class, 'index'])
    ->name('kemitraan');

Route::get('/sekolah', [PublicSekolahController::class, 'index'])
    ->name('sekolah');

Route::get('/program', [PublicProgramController::class, 'index'])
    ->name('program');

Route::get('/kegiatan', [PublicKegiatanController::class, 'index'])
    ->name('kegiatan');

Route::get('/arsip-laporan/file/{file}/pdf', [ArsipFileController::class, 'pdf'])->name('arsip.pdf');

Route::get('/arsip-laporan/file/{file}/tabel', [ArsipFileController::class, 'tabel'])->name('arsip.tabel');

Route::get('/tendik', [PublicTendikController::class, 'index'])->name('tendik');