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
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($blogs as $blog)
                <tr>
                    <td>
                        <img src="{{ asset('storage/' . $blog->gambar) }}" width="100">
                    </td>
                    <td>
                        <b><a href="{{ route('blogs.show', $blog->id) }}">{{ $blog->judul }}</a></b>
                        <br>
                        <small>
                            Tags:
                            @foreach ($blog->tags as $tag)
                                <span style="background: yellow;">{{ $tag->nama }}</span>
                            @endforeach
                        </small>
                    </td>
                    <td>{{ $blog->user->name }}</td>

                    <td>
                        <a href="{{ route('blogs.edit', $blog->id) }}">Edit</a>
                        |
                        <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus blog ini?')">Hapus</button>
                        </form>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
