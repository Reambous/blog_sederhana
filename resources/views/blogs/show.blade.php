<!DOCTYPE html>
<html>

<head>
    <title>{{ $blog->judul }}</title>
    <style>
        .container {
            width: 60%;
            margin: auto;
            font-family: sans-serif;
        }

        .img-fluid {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .badge {
            background: #eee;
            padding: 5px 10px;
            border-radius: 5px;
            margin-right: 5px;
        }

        .comment-box {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>

<body>

    <div class="container">

        <a href="{{ route('blogs.index') }}">&larr; Kembali ke Daftar</a>

        <br><br>

        <h1>{{ $blog->judul }}</h1>

        <p>
            <small>Ditulis oleh: <b>{{ $blog->user->name }}</b> | {{ $blog->created_at->format('d M Y') }}</small>
        </p>

        <img src="{{ asset('storage/' . $blog->gambar) }}" class="img-fluid">

        <div style="margin-top: 15px;">
            @foreach ($blog->tags as $tag)
                <span class="badge">#{{ $tag->nama }}</span>
            @endforeach
        </div>

        <hr>

        <p style="line-height: 1.6;">
            {!! nl2br(e($blog->isi)) !!}
        </p>

        <br>
        <hr><br>


        <h3>Komentar Pembaca ({{ $blog->comments->count() }})</h3>

        @forelse($blog->comments as $comment)
            <div class="comment-box">
                <b>{{ $comment->nama }}</b>
                <small style="color: grey;">({{ $comment->created_at->diffForHumans() }})</small>
                <br>
                {{ $comment->komentar }}
            </div>
        @empty
            <p>Belum ada komentar. Jadilah yang pertama!</p>
        @endforelse


        <div style="background-color: #f9f9f9; padding: 20px; border-radius: 8px; margin-top: 30px;">
            <h4>Tulis Komentar</h4>

            @if (session('success'))
                <div style="color: green; margin-bottom: 10px;">{{ session('success') }}</div>
            @endif

            <form action="{{ route('comments.store') }}" method="POST">
                @csrf

                <input type="hidden" name="blog_id" value="{{ $blog->id }}">

                <div>
                    <label>Nama:</label><br>
                    <input type="text" name="nama" style="width: 100%" required>
                </div>

                <div style="margin-top: 10px;">
                    <label>Email:</label><br>
                    <input type="email" name="email" style="width: 100%" required>
                </div>

                <div style="margin-top: 10px;">
                    <label>Isi Komentar:</label><br>
                    <textarea name="komentar" rows="3" style="width: 100%" required></textarea>
                </div>

                <br>
                <button type="submit">Kirim Komentar</button>
            </form>
        </div>

        <br><br><br>

    </div>

</body>

</html>
