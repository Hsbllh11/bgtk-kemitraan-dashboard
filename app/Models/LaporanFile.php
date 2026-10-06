<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanFile extends Model
{
    protected $fillable = [
        'folder_id',
        'nama',
        'nama_asli',
        'path',
        'mime_type',
        'ukuran',
        'uploaded_by',
    ];

    /**
     * Relasi ke folder.
     */
    public function folder(): BelongsTo
    {
        return $this->belongsTo(LaporanFolder::class, 'folder_id');
    }

    /**
     * Relasi ke user yang mengupload file.
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Format ukuran file.
     */
    public function getUkuranFormatAttribute(): string
    {
        $bytes = $this->ukuran ?? 0;

        return match (true) {
            $bytes >= 1073741824 => number_format($bytes / 1073741824, 2) . ' GB',
            $bytes >= 1048576 => number_format($bytes / 1048576, 2) . ' MB',
            $bytes >= 1024 => number_format($bytes / 1024, 1) . ' KB',
            default => $bytes . ' B',
        };
    }

    /**
     * Menentukan tipe file berdasarkan ekstensi.
     */
    public function getTipeAttribute(): string
    {
        return match (
            strtolower(
                pathinfo($this->nama_asli ?? $this->nama, PATHINFO_EXTENSION)
            )
        ) {
            'pdf' => 'pdf',

            'doc', 'docx' => 'word',

            'xls', 'xlsx', 'csv' => 'excel',

            'ppt', 'pptx' => 'ppt',

            'jpg', 'jpeg', 'png', 'gif', 'webp', 'svg' => 'image',

            'zip', 'rar', '7z' => 'archive',

            'mp4', 'avi', 'mkv', 'mov' => 'video',

            'mp3', 'wav', 'ogg' => 'audio',

            'txt' => 'text',

            default => 'other',
        };
    }
}