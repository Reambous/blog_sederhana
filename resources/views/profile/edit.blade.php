@extends('layout')

@section('title', 'Edit Profil')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-bold">
                    👤 Pengaturan Akun
                </div>
                <div class="card-body p-4">

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <h5 class="mb-3 text-primary">Data Diri</h5>

                        <div class="mb-4 text-center">
                            <div class="mb-2">
                                @if ($user->gambar)
                                    <img src="{{ asset('storage/' . $user->gambar) }}" class="rounded-circle border"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto"
                                        style="width: 100px; height: 100px; font-size: 2rem;">
                                        👤
                                    </div>
                                @endif
                            </div>

                            <label class="btn btn-sm btn-outline-primary cursor-pointer">
                                📸 Ganti Foto
                                <input type="file" name="foto" class="d-none" accept="image/*"
                                    onchange="this.form.submit()">
                            </label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $user->email) }}" required>
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-3 text-primary">Ganti Password</h5>
                        <div class="alert alert-info py-2 small">
                            ℹ️ Kosongkan bagian ini jika tidak ingin mengganti password.
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Ketik ulang password baru">
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-light">Kembali ke Dashboard</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
