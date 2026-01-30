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
        Schema::create('blogs', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Sesuai desain: UUID
            $table->string('judul');       // Judul
            $table->text('isi');           // Isi (Teks panjang)
            $table->text('gambar')->nullable(); // Gambar (boleh kosong)

            // Relasi ke User (Penulis)
            // Karena User pakai UUID, kita pakai foreignUuid
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
