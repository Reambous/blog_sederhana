@extends('layout')

@section('title', 'Edit Artikel')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-5">
                <div class="card-header bg-white">
                    <h4 class="mb-0">✏️ Edit Blog</h4>
                </div>
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Judul Artikel</label>
                            <input type="text" name="judul" class="form-control"
                                value="{{ old('judul', $blog->judul) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gambar Utama</label>

                            @if ($blog->gambar)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $blog->gambar) }}" class="img-thumbnail"
                                        style="max-height: 200px;">
                                    <div class="form-text text-muted">Gambar saat ini. Abaikan form di bawah jika tidak
                                        ingin mengganti.</div>
                                </div>
                            @endif

                            <input type="file" name="gambar" class="form-control" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Isi Tulisan</label>
                            <textarea name="isi" class="form-control" rows="10" required>{{ old('isi', $blog->isi) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">Pilih Tags</label>
                            <div class="border p-3 rounded bg-light">
                                @foreach ($tags as $tag)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="tags[]"
                                            value="{{ $tag->id }}" id="tag{{ $tag->id }}" {{-- LOGIKA: Cek apakah tag ini ada di daftar tags milik blog ini? --}}
                                            {{ $blog->tags->contains($tag->id) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="tag{{ $tag->id }}">{{ $tag->nama }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="alert alert-warning mt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="hapus_komentar" value="1"
                                    id="checkHapus">
                                <label class="form-check-label text-danger fw-bold" for="checkHapus">
                                    ⚠️ Hapus semua komentar lama?
                                </label>
                                <div class="form-text">
                                    Centang ini jika kamu mengubah isi artikel secara drastis agar komentar lama tidak
                                    membingungkan pembaca baru.
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg">Simpan Perubahan</button>
                            <a href="{{ route('blogs.index') }}" class="btn btn-light">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
