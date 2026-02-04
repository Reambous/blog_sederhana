<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Blog extends Model
{
    use HasFactory, HasUuids;

    // Masukkan semua kolom agar bisa diisi
    protected $fillable = ['judul', 'isi', 'gambar', 'user_id'];

    // Relasi 1: Blog dimiliki oleh User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi 2: Blog punya banyak Tag (Many to Many)
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'blog_tag');
    }
}
