<!DOCTYPE html>
<html>

<head>
    <title>Buat Tag Baru</title>
</head>

<body>

    <h1>Buat Tag Baru</h1>

    <form action="{{ route('tags.store') }}" method="POST">

        @csrf

        <label>Nama Tag:</label>
        <input type="text" name="nama" placeholder="Contoh: Coding">

        <button type="submit">Simpan</button>
    </form>

    <br>
    <a href="{{ route('tags.index') }}">Kembali</a>

</body>

</html>
