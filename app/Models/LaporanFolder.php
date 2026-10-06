<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class LaporanFolder extends Model
{
    protected $fillable = ['parent_id', 'nama', 'created_by'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(LaporanFile::class, 'folder_id');
    }

    /** Daftar folder dari root sampai folder ini (untuk breadcrumb). */
    public function breadcrumbs(): array
    {
        $trail = [];
        $current = $this;

        while ($current) {
            array_unshift($trail, $current);
            $current = $current->parent;
        }

        return $trail;
    }

    /** Hapus folder beserta isi (subfolder + file fisik). */
    public function deleteTree(): void
    {
        foreach ($this->children as $child) {
            $child->deleteTree();
        }

        foreach ($this->files as $file) {
            Storage::disk('local')->delete($file->path);
            $file->delete();
        }

        $this->delete();
    }
}