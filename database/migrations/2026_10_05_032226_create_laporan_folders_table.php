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
        Schema::create('laporan_folders', function (Blueprint $table) {
            $table->id();

            // Folder induk, null jika merupakan folder utama
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('laporan_folders')
                ->cascadeOnDelete();

            // Nama folder
            $table->string('nama');

            // User yang membuat folder
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            // Index untuk mempercepat pencarian folder berdasarkan parent
            $table->index('parent_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_folders');
    }
};