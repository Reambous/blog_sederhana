<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Tag extends Model
{
    use HasFactory, HasUuids; // 2. Pakai fitur UUID

    // 3. Keamanan: Hanya kolom 'nama' yang boleh diisi dari formulir
    protected $fillable = ['nama'];
}
