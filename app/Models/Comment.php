<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Comment extends Model
{
    use HasFactory, HasUuids; // <--- Pakai UUID

    // --- BAGIAN INI YANG KURANG ---
    // Kita harus daftarkan semua kolom yang diisi lewat Controller tadi
    protected $fillable = [
        'blog_id',
        'nama',
        'email',
        'komentar',
        'ip',
        'browser'
    ];

    // Relasi ke Blog (Komentar ini milik Blog yg mana?)
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
