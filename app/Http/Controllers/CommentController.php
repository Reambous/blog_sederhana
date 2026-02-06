<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi Input (Sesuai Flowchart: Wajib Judul/Isi Valid)
        $request->validate([
            'nama'     => 'required',
            'email'    => 'required|email',
            'komentar' => 'required',
            'blog_id'  => 'required|exists:blogs,id' // Pastikan ID blog valid
        ]);

        // 2. Simpan ke Database
        Comment::create([
            'blog_id'  => $request->blog_id,
            'nama'     => $request->nama,
            'email'    => $request->email,
            'komentar' => $request->komentar,

            // 3. Fitur Tambahan Sesuai Desain (IP & Browser)
            'ip'       => $request->ip(),          // Mengambil IP Address user
            'browser'  => $request->userAgent()    // Mengambil info browser (Chrome/Edge/dll)
        ]);

        // 4. Kembali ke halaman blog tadi (back)
        return back()->with('success', 'Komentar berhasil dikirim!');
    }

    // Hapus Komentar (Khusus Admin)
    public function destroy(string $id)
    {
        // Cari komentar, kalau gak ada error 404
        $comment = Comment::findOrFail($id);

        // Hapus
        $comment->delete();

        // Kembali ke halaman sebelumnya (blog detail) dengan pesan sukses
        return back()->with('success', 'Komentar berhasil dihapus demi kebersihan!');
    }
}
