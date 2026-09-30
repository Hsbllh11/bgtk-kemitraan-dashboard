<?php

use App\Http\Controllers\PublicHomeController;
use App\Http\Controllers\PublicKegiatanController;
use App\Http\Controllers\PublicKemitraanController;
use App\Http\Controllers\PublicProgramController;
use App\Http\Controllers\PublicSekolahController;
use Illuminate\Support\Facades\Route;

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