@extends('layout')

@section('title', 'Daftar Artikel')

@section('content')

    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="fw-bold">Artikel Terbaru</h2>
            <p class="text-muted">Baca tulisan menarik dari komunitas kami.</p>
        </div>
    </div>

    <div class="row">
        @forelse($blogs as $blog)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div style="height: 200px; overflow: hidden; background: #eee;">
                        @if ($blog->gambar)
                            <img src="{{ asset('storage/' . $blog->gambar) }}" class="card-img-top"
                                style="object-fit: cover; height: 100%; width: 100%;">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 text-muted">No Image</div>
                        @endif
                    </div>

                    <div class="card-body d-flex flex-column">
                        <div class="mb-2">
                            @foreach ($blog->tags as $tag)
                                <span class="badge bg-warning text-dark me-1">{{ $tag->nama }}</span>
                            @endforeach
                        </div>

                        <h5 class="card-title">
                            <a href="{{ route('blogs.show', $blog->id) }}" class="text-decoration-none text-dark">
                                {{ $blog->judul }}
                            </a>
                        </h5>

                        <p class="card-text text-muted small flex-grow-1">
                            {{ Str::limit($blog->isi, 100) }}
                        </p>

                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                            <small class="text-muted">✍️ {{ $blog->user->name }}</small>

                            <div class="dropdown">
                                <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">⋮</button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('blogs.edit', $blog->id) }}">Edit</a></li>
                                    <li>
                                        <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="dropdown-item text-danger"
                                                onclick="return confirm('Hapus?')">Hapus</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <h4 class="text-muted">Belum ada artikel. Yuk nulis!</h4>
            </div>
        @endforelse
    </div>

@endsection
