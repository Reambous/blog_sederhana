@extends('layout')

@section('title', $blog->judul)

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card p-4 mb-5">
                <div class="mb-3 text-center">
                    @foreach ($blog->tags as $tag)
                        <a href="{{ route('blogs.byTag', $tag->id) }}"
                            class="badge bg-warning text-dark text-decoration-none">
                            {{ $tag->nama }}
                        </a>
                    @endforeach

                    <h1 class="fw-bold mt-2">{{ $blog->judul }}</h1>
                </div>

                @if ($blog->gambar)
                    <img src="{{ asset('storage/' . $blog->gambar) }}" class="img-fluid rounded mb-4 w-100">
                @endif

                <div class="article-content" style="line-height: 1.8; font-size: 1.1rem;">
                    {!! nl2br(e($blog->isi)) !!}
                </div>
            </div>

            <div class="card bg-light border-0">
                <div class="card-body p-4">
                    <h4 class="mb-4">💬 Komentar ({{ $blog->comments->count() }})</h4>

                    @foreach ($blog->comments as $comment)
                        <div class="d-flex mb-3 pb-3 border-bottom">
                            <div class="shrink-0">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->nama) }}&background=random"
                                    class="rounded-circle" width="40">
                            </div>
                            <div class="ms-3 w-100">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-0 fw-bold">
                                            {{ $comment->nama }}
                                            @if ($blog->updated_at->gt($comment->created_at))
                                                <span class="badge bg-warning text-dark ms-1" style="font-size: 0.7em;">⚠️
                                                    Versi Lama</span>
                                            @endif
                                        </h6>
                                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                    </div>

                                    @auth
                                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-sm btn-outline-danger border-0 py-0 btn-delete"
                                                title="Hapus Komentar">
                                                🗑️
                                            </button>
                                        </form>
                                    @endauth
                                </div>

                                <p class="mt-1 mb-0 {{ $blog->updated_at->gt($comment->created_at) ? 'text-muted' : '' }}">
                                    {{ $comment->komentar }}
                                </p>
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-4">
                        <h5>Tulis Komentar</h5>
                        <form action="{{ route('comments.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="blog_id" value="{{ $blog->id }}">

                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <input type="text" name="nama" class="form-control" placeholder="Nama Kamu"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" name="email" class="form-control" placeholder="Email (Privat)"
                                        required>
                                </div>
                            </div>
                            <textarea name="komentar" class="form-control mb-2" rows="3" placeholder="Tulis tanggapanmu..." required></textarea>
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
