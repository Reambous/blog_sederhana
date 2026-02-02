<!DOCTYPE html>
<html>

<head>
    <title>Daftar Tags</title>
</head>

<body>

    <h1>Daftar Tags</h1>

    <a href="{{ route('tags.create') }}">+ Buat Tag Baru</a>

    <br><br>

    @if (session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Tag</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tags as $tag)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $tag->nama }}</td>
                    <td>
                        Edit | Hapus (Nanti)
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
