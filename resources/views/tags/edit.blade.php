<!DOCTYPE html>
<html>

<head>
    <title>Edit Tag</title>
</head>

<body>

    <h1>Edit Tag</h1>

    <form action="{{ route('tags.update', $tag->id) }}" method="POST">

        @csrf

        @method('PUT')

        <label>Nama Tag:</label>
        <input type="text" name="nama" value="{{ $tag->nama }}">

        <button type="submit">Update</button>
    </form>

    <br>
    <a href="{{ route('tags.index') }}">Batal</a>

</body>

</html>
