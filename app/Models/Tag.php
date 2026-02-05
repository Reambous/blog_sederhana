<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Tag extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['nama'];

    // --- TAMBAHKAN INI ---
    // Relasi Kebalikan: Tag dimiliki oleh Banyak Blog
    public function blogs()
    {
        // belongsToMany artinya "Milik Banyak"
        // 'blog_tag' adalah nama tabel penghubungnya
        return $this->belongsToMany(Blog::class, 'blog_tag');
    }
}
