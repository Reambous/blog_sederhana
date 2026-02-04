<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::latest()->get(); // Ambil data terbaru
        return view('blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Kita butuh data tags untuk dipilih di form (checkbox)
        $tags = Tag::all();
        return view('blogs.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // A. Validasi
        $request->validate([
            'judul'   => 'required|max:255',
            'isi'     => 'required',
            'gambar'  => 'required|image|mimes:jpeg,png,jpg|max:2048', // Wajib gambar, maks 2MB
            'tags'    => 'array' // Tags dikirim dalam bentuk array/list
        ]);

        // B. Upload Gambar
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            // Simpan ke folder 'public/blogs'
            $gambarPath = $request->file('gambar')->store('blogs', 'public');
        }

        // C. Ambil User (SEMENTARA: Pakai user pertama yg kita buat di seeder tadi)
        // Nanti kalau sudah ada login, ini diganti jadi: auth()->id()
        $user = User::first();

        // D. Simpan ke Database Blogs
        $blog = Blog::create([
            'judul'   => $request->judul,
            'isi'     => $request->isi,
            'gambar'  => $gambarPath,
            'user_id' => $user->id
        ]);

        // E. Simpan Relasi Tags (Pivot)
        // attach() fungsinya memasukkan data ke tabel blog_tag
        $blog->tags()->attach($request->tags);

        return redirect()->route('blogs.index')->with('success', 'Blog berhasil terbit!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // 1. Cari blog berdasarkan ID
        // 2. 'with("comments")' artinya: "Sekalian ambilkan komentarnya biar tidak bolak-balik database"
        // 3. 'findOrFail': Kalau ID ngawur, tampilkan Error 404
        $blog = Blog::with('comments')->findOrFail($id);

        // 4. Kirim data ke tampilan detail
        return view('blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::findOrFail($id);
        $tags = Tag::all(); // Kita butuh daftar semua tag untuk pilihan

        return view('blogs.edit', compact('blog', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi (Gambar tidak wajib diisi/nullable saat edit)
        $request->validate([
            'judul'   => 'required|max:255',
            'isi'     => 'required',
            'gambar'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tags'    => 'array'
        ]);

        $blog = Blog::findOrFail($id);

        // Cek apakah user upload gambar baru?
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama dari storage biar hemat memori
            if ($blog->gambar) {
                Storage::disk('public')->delete($blog->gambar);
            }
            // Simpan gambar baru
            $gambarPath = $request->file('gambar')->store('blogs', 'public');

            // Update path gambar di database
            $blog->update(['gambar' => $gambarPath]);
        }

        // Update Judul & Isi
        $blog->update([
            'judul' => $request->judul,
            'isi'   => $request->isi
        ]);

        // Update Relasi Tags (PENTING)
        // sync() otomatis menghapus tag lama dan mengganti dengan yang baru dipilih
        $blog->tags()->sync($request->tags);

        return redirect()->route('blogs.index')->with('success', 'Blog berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);

        // Hapus gambar fisiknya dulu dari folder storage
        if ($blog->gambar) {
            Storage::disk('public')->delete($blog->gambar);
        }

        // Hapus datanya dari database (Otomatis hapus komen & tag karena 'cascade')
        $blog->delete();

        return redirect()->route('blogs.index')->with('success', 'Blog berhasil dihapus!');
    }
}
