<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mulai Query Dasar (belum dieksekusi)
        // Kita siapkan query untuk mengambil Blog + Hitung Komentar
        $query = Blog::withCount('comments')->latest();

        // --- LOGIKA PENCARIAN ---
        // Cek: Apakah di URL ada ?search=sesuatu ?
        if (request('search')) {
            // Kalau ada, filter query-nya
            $query->where(function ($q) {
                $q->where('judul', 'like', '%' . request('search') . '%')
                    ->orWhere('isi', 'like', '%' . request('search') . '%');
            });
        }
        // ------------------------

        // Eksekusi (ambil datanya dengan pagination)
        $blogs = $query->paginate(4);

        // Ambil tags untuk sidebar
        $tags = Tag::all();

        return view('blogs.index', compact('blogs', 'tags'));
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

        // D. Simpan ke Database Blogs
        $blog = Blog::create([
            'judul'   => $request->judul,
            'isi'     => $request->isi,
            'gambar'  => $gambarPath,
            'user_id' => Auth::id()
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

        // Cek apakah admin mencentang kotak "Hapus Komentar"?
        if ($request->has('hapus_komentar')) {
            // Hapus semua komentar milik blog ini
            $blog->comments()->delete();
        }

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

    public function filterByTag(string $id)
    {
        $tag = Tag::findOrFail($id);

        // Filter blog berdasarkan tag, tapi tetap hitung komentarnya
        $blogs = $tag->blogs()->withCount('comments')->latest()->paginate(6);

        // Kita tetap butuh daftar semua tag untuk sidebar
        $tags = Tag::all();

        return view('blogs.index', compact('blogs', 'tags', 'tag'));
    }
}
