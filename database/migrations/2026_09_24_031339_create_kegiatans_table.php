<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->id();

            $table->string('nama_kegiatan');
            $table->string('jenis_kegiatan');
            $table->string('kabupaten_kota');
            $table->string('lokasi')->nullable();

            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();

            $table->string('penanggung_jawab')->nullable();

            $table->string('status')->default('Direncanakan');

            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kegiatans');
    }
};