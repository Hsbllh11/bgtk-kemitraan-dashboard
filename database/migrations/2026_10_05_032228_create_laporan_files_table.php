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
        Schema::create('laporan_files', function (Blueprint $table) {
            $table->id();

            // Folder tempat file berada
            $table->foreignId('folder_id')
                ->nullable()
                ->constrained('laporan_folders')
                ->cascadeOnDelete();

            // Nama file yang ditampilkan
            $table->string('nama');

            // Nama file asli
            $table->string('nama_asli')->nullable();

            // Lokasi file di storage
            $table->string('path');

            // MIME type, contoh: application/pdf
            $table->string('mime_type')->nullable();

            // Ukuran file dalam byte
            $table->unsignedBigInteger('ukuran')->nullable();

            // User yang mengupload
            $table->foreignId('uploaded_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            // Index untuk pencarian berdasarkan folder
            $table->index('folder_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_files');
    }
};