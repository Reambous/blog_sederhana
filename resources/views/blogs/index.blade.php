<!DOCTYPE html>
<html>

<head>
    <title>Daftar Blog</title>
</head>

<body>

    <h1>Daftar Blog</h1>
    <a href="{{ route('blogs.create') }}">+ Tulis Blog</a>
    <a href="{{ route('tags.index') }}">Kelola Tags</a>

    <table border="1" cellpadding="10" cellspacing="0" style="margin-top: 20px;">
        <thead>
            <tr>
                <th>Gambar</th>
                <th>Judul & Tags</th>
                <th>Penulis</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($blogs as $blog)
                <tr>
                    <td>
                        <img src="{{ asset('storage/' . $blog->gambar) }}" width="100">
                    </td>
                    <td>
                        <b>{{ $blog->judul }}</b>
                        <br>
                        <small>
                            Tags:
                            @foreach ($blog->tags as $tag)
                                <span style="background: yellow;">{{ $tag->nama }}</span>
                            @endforeach
                        </small>
                    </td>
                    <td>{{ $blog->user->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
