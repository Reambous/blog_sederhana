<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Blog extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['judul', 'isi', 'gambar', 'user_id'];

    // Relasi 1: Blog milik User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi 2: Blog punya banyak Tag
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'blog_tag');
    }

    // --- TAMBAHKAN INI ---
    // Relasi 3: Blog punya banyak Komentar
    public function comments()
    {
        // hasMany artinya "Satu Blog punya BANYAK Komentar"
        return $this->hasMany(Comment::class);
    }
}
