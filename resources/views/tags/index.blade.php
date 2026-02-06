@extends('layout')

@section('title', 'Kelola Tags')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">🏷️ Kelola Tags</h3>
                <a href="{{ route('tags.create') }}" class="btn btn-primary">+ Tag Baru</a>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;" class="text-center">#</th>
                                <th>Nama Tag</th>
                                <th style="width: 200px;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tags as $tag)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="badge bg-secondary text-light" style="font-size: 0.9rem;">
                                            {{ $tag->nama }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('tags.edit', $tag->id) }}"
                                            class="btn btn-sm btn-warning me-1">Edit</a>

                                        <form action="{{ route('tags.destroy', $tag->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-delete">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">
                                        Belum ada tags. Silakan buat baru.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

@endsection
