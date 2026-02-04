@extends('layout')

@section('title', $blog->judul)

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card p-4 mb-5">
                <div class="mb-3 text-center">
                    @foreach ($blog->tags as $tag)
                        <span class="badge bg-warning text-dark">{{ $tag->nama }}</span>
                    @endforeach
                    <h1 class="fw-bold mt-2">{{ $blog->judul }}</h1>
                    <p class="text-muted">
                        Ditulis oleh <b>{{ $blog->user->name }}</b> &bull; {{ $blog->created_at->format('d M Y') }}
                    </p>
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
                            <div class="flex-shrink-0">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->nama) }}&background=random"
                                    class="rounded-circle" width="40">
                            </div>
                            <div class="ms-3 w-100">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 fw-bold">
                                        {{ $comment->nama }}

                                        @if ($blog->updated_at->gt($comment->created_at))
                                            <span class="badge bg-warning text-dark ms-2" style="font-size: 0.7em;"
                                                title="Komentar ini diposting pada versi artikel sebelumnya">
                                                ⚠️ Versi Lama
                                            </span>
                                        @endif
                                    </h6>
                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                </div>

                                <p class="mt-1 mb-0 {{ $blog->updated_at->gt($comment->created_at) ? 'text-muted' : '' }}">
                                    {{ $comment->komentar }}
                                </p>

                                @if ($blog->updated_at->gt($comment->created_at))
                                    <small style="font-size: 0.75rem; color: #d63384;">
                                        *Artikel telah diedit setelah komentar ini.
                                    </small>
                                @endif
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
