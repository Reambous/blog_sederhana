<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Untuk enkripsi password
use Illuminate\Support\Facades\Auth; // Untuk ambil data user login
use Illuminate\Validation\Rule;      // Untuk validasi email unik
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // 1. Tampilkan Form Edit Profil
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user()
        ]);
    }

    // 2. Simpan Perubahan
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Validasi
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            // Validasi Foto: Harus gambar, maks 2MB
            'foto'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|min:6|confirmed',
        ]);

        // 2. Update Data Dasar
        $user->name = $request->name;
        $user->email = $request->email;

        // 3. Proses Upload Foto (LOGIKA BARU)
        if ($request->hasFile('foto')) {
            // A. Hapus foto lama jika ada (dan bukan foto default/kosong)
            if ($user->gambar) {
                Storage::disk('public')->delete($user->gambar);
            }

            // B. Simpan foto baru ke folder 'profiles'
            $path = $request->file('foto')->store('profiles', 'public');

            // C. Simpan path-nya ke database
            $user->gambar = $path;
        }

        // 4. Update Password (jika diisi)
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil dan foto berhasil diperbarui!');
    }
}
