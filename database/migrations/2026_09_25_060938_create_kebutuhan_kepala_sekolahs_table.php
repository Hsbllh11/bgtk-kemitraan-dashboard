<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kebutuhan_kepala_sekolahs', function (Blueprint $table) {
            $table->id();

            // Tahun data
            $table->unsignedSmallInteger('tahun')->default(2026);

            // Wilayah
            $table->string('kabupaten_kota');

            // Data sekolah
            $table->string('nama_sekolah');
            $table->string('nama_kepala_sekolah')->nullable();
            $table->string('lokasi_sekolah')->nullable();

            // Data kepala sekolah
            $table->unsignedTinyInteger('usia')->nullable();
            $table->string('status_ks')->nullable();

            // Status sekolah
            $table->string('status_sekolah')->nullable();

            // Data masa tugas/pensiun
            $table->date('tanggal_pensiun')->nullable();
            $table->string('akhir_periode')->nullable();
            $table->string('periode_penugasan')->nullable();

            // Hasil pemetaan
            $table->string('pemetaan')->nullable();

            $table->timestamps();

            // Index untuk mempercepat filter dashboard
            $table->index('kabupaten_kota');
            $table->index('status_ks');
            $table->index('status_sekolah');
            $table->index('pemetaan');
            $table->index('tahun');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kebutuhan_kepala_sekolahs');
    }
};