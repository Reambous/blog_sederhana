<!DOCTYPE html>
<html>

<head>
    <title>Tulis Blog Baru</title>
</head>

<body>

    <h1>Tulis Blog Baru</h1>

    <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label>Judul:</label><br>
            <input type="text" name="judul" required>
        </div>

        <div>
            <label>Gambar:</label><br>
            <input type="file" name="gambar" accept="image/*" required>
        </div>

        <div>
            <label>Isi Artikel:</label><br>
            <textarea name="isi" rows="5" cols="40" required></textarea>
        </div>

        <div>
            <label>Pilih Tags:</label><br>
            @foreach ($tags as $tag)
                <input type="checkbox" name="tags[]" value="{{ $tag->id }}">
                {{ $tag->nama }} <br>
            @endforeach
        </div>

        <br>
        <button type="submit">Terbitkan</button>
    </form>

</body>

</html>
