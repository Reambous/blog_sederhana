<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1. Suruh Model ambil semua data tag
        $tags = \App\Models\Tag::all();

        // 2. Kirim data itu ke View (kita akan buat view-nya sebentar lagi)
        return view('tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Tampilkan halaman formulir
        return view('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi: Pastikan nama diisi
        $request->validate([
            'nama' => 'required|max:255'
        ]);

        // 2. Simpan ke Database
        \App\Models\Tag::create([
            'nama' => $request->nama
        ]);

        // 3. Kembalikan ke halaman daftar dengan pesan sukses
        return redirect()->route('tags.index')->with('success', 'Tag berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
