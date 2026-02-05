<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Untuk enkripsi password
use Illuminate\Support\Facades\Auth; // Untuk ambil data user login
use Illuminate\Validation\Rule;      // Untuk validasi email unik

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

        // Validasi
        $request->validate([
            'name'  => 'required|string|max:255',
            // Pastikan email unik, TAPI abaikan (ignore) email milik user ini sendiri
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            // Password boleh kosong (nullable) kalau tidak mau diganti
            'password' => 'nullable|min:6|confirmed',
        ]);

        // Update Data Dasar
        $user->name = $request->name;
        $user->email = $request->email;

        // Cek: Apakah user mengisi password baru?
        if ($request->filled('password')) {
            // Hash password baru dan simpan
            $user->password = Hash::make($request->password);
        }

        // Simpan ke database (karena model User pakai UUID & incrementing=false, kita pakai save() biasa aman)
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
