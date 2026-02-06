<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blog Sederhana')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar-brand {
            font-weight: bold;
            color: #4a5568 !important;
        }

        .card {
            border: none;
            shadow-sm: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('blogs.index') }}">🚀 LaraBlog</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('blogs.index') }}">Beranda</a>
                    </li>

                    @auth
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('blogs.create') }}">+ Tulis Blog</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tags.index') }}">Kelola Tags</a>
                        </li>

                        <li class="nav-item dropdown ms-2">
                            <a class="nav-link dropdown-toggle fw-bold d-flex align-items-center gap-2" href="#"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                @if (Auth::user()->gambar)
                                    <img src="{{ asset('storage/' . Auth::user()->gambar) }}" class="rounded-circle"
                                        style="width: 30px; height: 30px; object-fit: cover;">
                                @else
                                    👤
                                @endif

                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">⚙️ Pengaturan Akun</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Keluar / Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth

                    @guest
                        <li class="nav-item ms-2">
                            <a class="nav-link btn btn-outline-primary px-4 btn-sm" href="{{ route('login') }}">Login
                                Admin</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <footer class="text-center py-4 mt-5 text-muted">
        <small>&copy; 2026 Blog Sederhana dengan Laravel</small>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Logika Tombol Hapus (btn-delete)
        document.addEventListener('click', function(e) {
            // Cek apakah yang diklik adalah tombol dengan class 'btn-delete'
            if (e.target && e.target.classList.contains('btn-delete')) {
                e.preventDefault(); // Tahan dulu, jangan kirim
                let form = e.target.closest('form'); // Ambil form pembungkusnya

                // Munculkan Pop-up Tanya
                Swal.fire({
                    title: 'Yakin mau hapus?',
                    text: "Data tidak bisa kembali!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Kalau User klik Ya, baru kirim
                    }
                });
            }
        });

        // Logika Notifikasi Sukses (Hijau)
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        @endif
    </script>

</body>

</html>
