@extends('layout')

@section('title', 'Dashboard Admin')

@section('content')

    <h2 class="mb-4">👋 Selamat Datang, {{ Auth::user()->name }}!</h2>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3 shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Artikel</h5>
                    <h1 class="card-text fw-bold">{{ $totalBlogs }}</h1>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3 shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Tags</h5>
                    <h1 class="card-text fw-bold">{{ $totalTags }}</h1>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning text-dark mb-3 shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Komentar</h5>
                    <h1 class="card-text fw-bold">{{ $totalComments }}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-white fw-bold">
            💬 5 Komentar Terbaru
        </div>
        <ul class="list-group list-group-flush">
            @forelse($recentComments as $comment)
                <li class="list-group-item">
                    <small class="text-muted">{{ $comment->nama }}</small> di artikel
                    <a href="{{ route('blogs.show', $comment->blog_id) }}">{{ Str::limit($comment->blog->judul, 30) }}</a>:
                    <br>
                    <i>"{{ Str::limit($comment->komentar, 50) }}"</i>
                </li>
            @empty
                <li class="list-group-item text-center text-muted">Belum ada komentar masuk.</li>
            @endforelse
        </ul>
    </div>

@endsection
