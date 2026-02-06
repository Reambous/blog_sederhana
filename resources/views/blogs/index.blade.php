@extends('layout')

@section('title', 'Beranda Blog')

@section('content')

    <div class="row">

        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">🔍 Cari Artikel</h5>
                    <form action="{{ route('blogs.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Ketik judul..."
                                value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                <div class="card-header bg-white fw-bold">
                    🏷️ Pilihan Kategori
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('blogs.index') }}"
                        class="list-group-item list-group-item-action {{ !isset($tag) ? 'active' : '' }}">
                        Semua Artikel
                    </a>

                    @foreach ($tags as $t)
                        <a href="{{ route('blogs.byTag', $t->id) }}"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ isset($tag) && $tag->id == $t->id ? 'active' : '' }}">

                            {{ $t->nama }}

                            <span class="badge bg-secondary rounded-pill" style="font-size: 0.7em;">
                                {{ $t->blogs()->count() }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>


        <div class="col-md-9">

            <div class="mb-4">
                @if (request('search'))
                    <h3 class="fw-bold">Hasil Pencarian: "<span class="text-primary">{{ request('search') }}</span>"</h3>
                    <p class="text-muted">
                        Ditemukan {{ $blogs->total() }} artikel.
                        <a href="{{ route('blogs.index') }}" class="text-decoration-none">Reset Pencarian</a>
                    </p>
                @elseif(isset($tag))
                    <h3 class="fw-bold">📂 Kategori: <span class="text-primary">{{ $tag->nama }}</span></h3>
                    <p class="text-muted">Menampilkan artikel sesuai pilihanmu.</p>
                @else
                    <h3 class="fw-bold">Artikel Terbaru</h3>
                    <p class="text-muted">Baca tulisan menarik dari komunitas kami.</p>
                @endif
            </div>

            <div class="row">
                @forelse($blogs as $blog)
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow-sm hover-card">
                            <div style="height: 200px; overflow: hidden; background: #eee;">
                                @if ($blog->gambar)
                                    <img src="{{ asset('storage/' . $blog->gambar) }}" class="card-img-top"
                                        style="object-fit: cover; height: 100%; width: 100%;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100 text-muted">No Image
                                    </div>
                                @endif
                            </div>

                            <div class="card-body d-flex flex-column">
                                <div class="mb-2">
                                    @foreach ($blog->tags->take(2) as $blogTag)
                                        <span class="badge bg-light text-dark border">{{ $blogTag->nama }}</span>
                                    @endforeach
                                </div>

                                <h5 class="card-title fw-bold">
                                    <a href="{{ route('blogs.show', $blog->id) }}"
                                        class="text-decoration-none text-dark stretched-link">
                                        {{ $blog->judul }}
                                    </a>
                                </h5>

                                <p class="card-text text-muted small grow">
                                    {{ Str::limit($blog->isi, 80) }}
                                </p>

                                <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                                    <div class="d-flex align-items-center gap-2">
                                        @if ($blog->user->gambar)
                                            <img src="{{ asset('storage/' . $blog->user->gambar) }}" class="rounded-circle"
                                                style="width: 35px; height: 35px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center border"
                                                style="width: 35px; height: 35px;">👤</div>
                                        @endif

                                        <div>
                                            <small class="fw-bold d-block text-dark">{{ $blog->user->name }}</small>
                                            <small class="text-muted d-block" style="font-size: 0.75rem;">💬
                                                {{ $blog->comments_count }} Komentar</small>
                                        </div>
                                    </div>

                                    @auth
                                        <div class="d-flex gap-2" style="position: relative; z-index: 2;">

                                            <a href="{{ route('blogs.edit', $blog->id) }}"
                                                class="btn btn-sm btn-outline-warning" title="Edit">
                                                ✏️
                                            </a>

                                            <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger btn-delete"
                                                    title="Hapus">
                                                    🗑️
                                                </button>
                                            </form>
                                        </div>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486754.png" width="100"
                            class="mb-3 opacity-50">
                        <h5 class="text-muted">Belum ada artikel di kategori ini.</h5>
                        <a href="{{ route('blogs.index') }}" class="btn btn-outline-primary mt-2">Lihat Semua</a>
                    </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-5 mb-4">
                {{ $blogs->links() }}
            </div>

        </div>
    </div>

    <style>
        .hover-card {
            transition: transform 0.2s;
        }

        .hover-card:hover {
            transform: translateY(-5px);
        }

        .list-group-item.active {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
    </style>

@endsection
