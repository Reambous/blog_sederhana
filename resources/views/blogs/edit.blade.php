<!DOCTYPE html>
<html>

<head>
    <title>Edit Blog</title>
</head>

<body>

    <h1>Edit Blog</h1>

    <form action="{{ route('blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <div>
            <label>Judul:</label><br>
            <input type="text" name="judul" value="{{ $blog->judul }}" required>
        </div>

        <div>
            <label>Gambar Saat Ini:</label><br>
            <img src="{{ asset('storage/' . $blog->gambar) }}" width="150"><br>
            <small>Biarkan kosong jika tidak ingin mengganti gambar.</small><br>
            <input type="file" name="gambar" accept="image/*">
        </div>

        <div>
            <label>Isi Artikel:</label><br>
            <textarea name="isi" rows="5" cols="40" required>{{ $blog->isi }}</textarea>
        </div>

        <div>
            <label>Pilih Tags:</label><br>
            @foreach ($tags as $tag)
                <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                    {{ $blog->tags->contains($tag->id) ? 'checked' : '' }}>

                {{ $tag->nama }} <br>
            @endforeach
        </div>

        <br>
        <button type="submit">Update Blog</button>
    </form>

    <br>
    <a href="{{ route('blogs.index') }}">Batal</a>

</body>

</html>
